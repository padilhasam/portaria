<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
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
        $horaInicio = Carbon::parse($this->horario_inicio);
        $horaFim = Carbon::parse($this->horario_fim);

        // 1. Não pode agendar para o passado
        if ($dataAgendamento->isBefore($agora->startOfDay())) {
            throw ValidationException::withMessages(['data_agendamento' => 'Não é possível agendar uma data passada.']);
        }

        // 2. Hora de início deve ser menor que hora de fim
        if ($horaInicio->gte($horaFim)) {
            throw ValidationException::withMessages(['horario_inicio' => 'A hora de início deve ser antes da hora de fim.']);
        }

        // 3. Horário permitido (08:00 - 22:00)
        $horaInicioPermitida = config('agendamento.horario_inicio');
        $horaFimPermitida = config('agendamento.horario_fim');

        if ($horaInicio->hour < $horaInicioPermitida || 
        ($horaFim->hour > $horaFimPermitida || ($horaFim->hour == $horaFimPermitida && $horaFim->minute > 0))) {
            throw ValidationException::withMessages(['horario_inicio' => "O horário deve ser entre {$horaInicioPermitida}:00 e {$horaFimPermitida}:00."]);
        }

        // 4. Checar se já existe agendamento sobreposto na mesma área
        $existeConflito = self::where('nome_area', $this->nome_area)
            ->where('data_agendamento', $this->data_agendamento)
            ->where(function ($query) {
                $query->whereBetween('horario_inicio', [$this->horario_inicio, $this->horario_fim])
                      ->orWhereBetween('horario_fim', [$this->horario_inicio, $this->horario_fim])
                      ->orWhere(function ($query) {
                          $query->where('horario_inicio', '<=', $this->horario_inicio)
                                ->where('horario_fim', '>=', $this->horario_fim);
                      });
            })
            ->exists();

        if ($existeConflito) {
            throw ValidationException::withMessages(['horario_inicio' => 'Já existe um agendamento para essa área nesse horário.']);
        }
    }

    public function morador()
    {
        return $this->belongsTo(Morador::class, 'id_usuario');
    }
}
