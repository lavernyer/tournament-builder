<?php

namespace App\Domain\Draw\Builder\Struct;

use App\Domain\Draw\Builder\BuilderOptions;
use App\Domain\Draw\Builder\TournamentBuilder;

final class EightQualifiersTournamentStruct implements TournamentStruct
{
    public function build(TournamentBuilder $builder, BuilderOptions $options): void
    {
        $builder
            ->roundRobin('qualification')
                ->setParticipants($options->getParticipantCount())
                ->setDivisions($options->getDivisionCount())
                ->setQualify($options->getQualifyCount())
                ->end()
            // elimination rounds should be called in loop according to settings
            ->elimination('Quarter Finals')->end()
            ->elimination('Semi Finals')->end()
            ->elimination('Final')
                ->stage('3rd place', 'elimination') // not implemented
                ->end()
            ->end();
    }
}
