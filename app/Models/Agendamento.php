<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'id_morador',
        'nome_area',
        'data_agendamento',
        'horario_inicio',
        'horario_fim',
        'observacoes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(fn($agendamento) => $agendamento->validarAgendamento());
        static::updating(fn($agendamento) => $agendamento->validarAgendamento());
    }

    public function validarAgendamento()
    {
        $agora = Carbon::now();
        $dataAgendamento = Carbon::parse($this->data_agendamento);
        $horaInicio = Carbon::parse($this->horario_inicio);
        $horaFim = Carbon::parse($this->horario_fim);

        // Valida data passada
        if ($dataAgendamento->isBefore($agora->startOfDay())) {
            throw ValidationException::withMessages([
                'data_agendamento' => 'Não é possível agendar uma data no passado.'
            ]);
        }

        // Valida ordem de horários
        if ($horaInicio->gte($horaFim)) {
            throw ValidationException::withMessages([
                'horario_inicio' => 'O horário de início deve ser anterior ao horário de fim.'
            ]);
        }

        // Horários permitidos (com fallback)
        $horaInicioPermitida = Config::get('agendamento.horario_inicio', 8);
        $horaFimPermitida = Config::get('agendamento.horario_fim', 22);

        if ($horaInicio->hour < $horaInicioPermitida) {
            throw ValidationException::withMessages([
                'horario_inicio' => "O horário de início deve ser a partir de {$horaInicioPermitida}:00."
            ]);
        }

        if ($horaFim->hour > $horaFimPermitida || 
            ($horaFim->hour == $horaFimPermitida && $horaFim->minute > 0)) {
            throw ValidationException::withMessages([
                'horario_fim' => "O horário de fim deve ser até {$horaFimPermitida}:00."
            ]);
        }

        // Verifica conflitos com outros agendamentos
        $query = self::where('nome_area', $this->nome_area)
            ->where('data_agendamento', $this->data_agendamento)
            ->where(function ($q) {
                $q->whereBetween('horario_inicio', [$this->horario_inicio, $this->horario_fim])
                  ->orWhereBetween('horario_fim', [$this->horario_inicio, $this->horario_fim])
                  ->orWhere(function ($subq) {
                      $subq->where('horario_inicio', '<=', $this->horario_inicio)
                           ->where('horario_fim', '>=', $this->horario_fim);
                  });
            });

        if ($this->exists) {
            $query->where('id', '!=', $this->id); // Evita conflito com o próprio registro
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'horario_inicio' => 'Já existe um agendamento para essa área nesse horário.'
            ]);
        }
    }

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function morador()
    {
        return $this->belongsTo(Morador::class, 'id_morador');
    }
}