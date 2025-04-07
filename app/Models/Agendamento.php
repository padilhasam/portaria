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
        'area',
        'data',
        'hora_inicio',
        'hora_fim',
        'usuario_id',
        'status',
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
        $dataAgendamento = Carbon::parse($this->data);
        $horaInicio = Carbon::parse($this->hora_inicio);
        $horaFim = Carbon::parse($this->hora_fim);

        // 1. Não pode agendar para o passado
        if ($dataAgendamento->isBefore($agora->startOfDay())) {
            throw ValidationException::withMessages(['data' => 'Não é possível agendar uma data passada.']);
        }

        // 2. Hora de início deve ser menor que hora de fim
        if ($horaInicio->gte($horaFim)) {
            throw ValidationException::withMessages(['hora_inicio' => 'A hora de início deve ser antes da hora de fim.']);
        }

        // 3. Horário permitido (08:00 - 22:00)
        if ($horaInicio->hour < 8 || $horaFim->hour > 22 || ($horaFim->hour == 22 && $horaFim->minute > 0)) {
            throw ValidationException::withMessages(['hora_inicio' => 'O horário deve ser entre 08:00 e 22:00.']);
        }

        // 4. Checar se já existe agendamento sobreposto na mesma área
        $existeConflito = self::where('area', $this->area)
            ->where('data', $this->data)
            ->where(function ($query) {
                $query->whereBetween('hora_inicio', [$this->hora_inicio, $this->hora_fim])
                      ->orWhereBetween('hora_fim', [$this->hora_inicio, $this->hora_fim])
                      ->orWhere(function ($query) {
                          $query->where('hora_inicio', '<=', $this->hora_inicio)
                                ->where('hora_fim', '>=', $this->hora_fim);
                      });
            })
            ->exists();

        if ($existeConflito) {
            throw ValidationException::withMessages(['hora_inicio' => 'Já existe um agendamento para essa área nesse horário.']);
        }
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
