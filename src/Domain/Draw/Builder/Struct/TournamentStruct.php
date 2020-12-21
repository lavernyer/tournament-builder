<?php

declare(strict_types=1);

namespace App\Domain\Draw\Builder\Struct;

use App\Domain\Draw\Builder\BuilderOptions;
use App\Domain\Draw\Builder\TournamentBuilder;

interface TournamentStruct
{
    public function build(TournamentBuilder $builder, BuilderOptions $options): void;
}