<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
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

        static::creating(function ($agendamento) {
            $agendamento->validarAgendamento();
        });

        static::updating(function ($agendamento) {
            $agendamento->validarAgendamento();
        });
    }

    public function validarAgendamento()
    {
        $agora = Carbon::now();
        $dataAgendamento = Carbon::parse($this->data_agendamento);
        $horaInicio = Carbon::createFromFormat('H:i', $this->horario_inicio);
        $horaFim = Carbon::createFromFormat('H:i', $this->horario_fim);

        if ($dataAgendamento->isBefore($agora->startOfDay())) {
            throw ValidationException::withMessages([
                'data_agendamento' => 'Não é possível agendar uma data passada.'
            ]);
        }

        if ($horaInicio->gte($horaFim)) {
            throw ValidationException::withMessages([
                'horario_inicio' => 'A hora de início deve ser antes da hora de fim.'
            ]);
        }

        $horaInicioPermitida = config('agendamento.horario_inicio', 8);
        $horaFimPermitida = config('agendamento.horario_fim', 22);

        if ($horaInicio->hour < $horaInicioPermitida) {
            throw ValidationException::withMessages([
                'horario_inicio' => "O horário de início deve ser a partir de {$horaInicioPermitida}:00."
            ]);
        }

        if (
            $horaFim->hour > $horaFimPermitida ||
            ($horaFim->hour == $horaFimPermitida && $horaFim->minute > 0)
        ) {
            throw ValidationException::withMessages([
                'horario_fim' => "O horário de fim deve ser até {$horaFimPermitida}:00."
            ]);
        }

        $query = self::where('nome_area', $this->nome_area)
            ->where('data_agendamento', $this->data_agendamento)
            ->where(function ($query) {
                $query->whereBetween('horario_inicio', [$this->horario_inicio, $this->horario_fim])
                    ->orWhereBetween('horario_fim', [$this->horario_inicio, $this->horario_fim])
                    ->orWhere(function ($query) {
                        $query->where('horario_inicio', '<=', $this->horario_inicio)
                            ->where('horario_fim', '>=', $this->horario_fim);
                    });
            });

        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'horario_inicio' => 'Já existe um agendamento para essa área nesse horário.'
            ]);
        }
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function morador()
    {
        return $this->belongsTo(Morador::class, 'id_morador');
    }
}