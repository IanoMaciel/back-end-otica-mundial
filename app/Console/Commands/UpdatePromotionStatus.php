<?php

namespace App\Console\Commands;

use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePromotionStatus extends Command {
    protected $signature = 'promotion:update-status';
    protected $description = 'Atualize o status da promoção com base na data atual';


    public function handle(): int {
        $now = Carbon::now();

        $now = Carbon::now();

        // Atualiza promoções agendadas para ativas
        $agendadasParaAtivar = Promotion::query()->where('status', 'Agendanda')
            ->where('start', '<=', $now)
            ->get();

        foreach ($agendadasParaAtivar as $promocao) {
            $promocao->status = 'Ativa';
            $promocao->save();
            $this->info("Promoção ID {$promocao->id} foi ativada.");
        }

        // Atualiza promoções ativas para inativas
        $ativasParaInativar = Promotion::query()->where('status', 'Ativa')
            ->where('end', '<', $now)
            ->get();

        foreach ($ativasParaInativar as $promocao) {
            $promocao->status = 'Inativa';
            $promocao->save();
            $this->info("Promoção ID {$promocao->id} foi inativada.");
        }

        $this->info("Atualização de status concluída. {$agendadasParaAtivar->count()} promoções ativadas e {$ativasParaInativar->count()} promoções inativadas.");

        return Command::SUCCESS;
    }
}
