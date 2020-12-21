<?php

declare(strict_types=1);

namespace App\Domain\Draw;

interface StageRepository
{
    public function byId(StageId $id): ?Stage;

    public function add(Stage $stage): void;

    public function addMulti(Stage ...$stages): void;

    public function update(Stage $stage): void;

}