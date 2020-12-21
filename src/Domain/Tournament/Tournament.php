<?php

declare(strict_types=1);

namespace App\Domain\Tournament;

use App\Domain\Competitor\Competitor;
use App\Domain\Competitor\CompetitorId;
use App\Domain\Tournament\Event\TournamentSignupCompleted;
use App\Infrastructure\EventSauce\AggregateRootTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DomainException;
use EventSauce\EventSourcing\AggregateRoot;
use Symfony\Component\Workflow\WorkflowInterface;

final class Tournament implements AggregateRoot
{
    use AggregateRootTrait;

    private int $incrementalId;
    private TournamentStatus $status;
    private Collection $participants;
    private ?Participant $winner = null;
    private DateTimeImmutable $createdOn;
    private DateTimeImmutable $updatedOn;

    public function __construct(
        private TournamentId $id,
        private TournamentConfig $config,
    )
    {
        $this->status = TournamentStatus::SIGNUP();
        $this->participants = new ArrayCollection();
        $this->createdOn = $this->updatedOn = new DateTimeImmutable();
    }

    public function getId(): TournamentId
    {
        return $this->id;
    }

    public function getConfig(): TournamentConfig
    {
        return $this->config;
    }

    public function getStatus(): TournamentStatus
    {
        return $this->status;
    }

    public function getStatusString(): string
    {
        return $this->getStatus()->toString();
    }

    public function getWinner(): ?Participant
    {
        return $this->winner;
    }

    public function getCreatedOn(): DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function getUpdatedOn(): DateTimeImmutable
    {
        return $this->updatedOn;
    }

    public function getParticipants(): array
    {
        return $this->participants->toArray();
    }

    public function addParticipant(WorkflowInterface $workflow, Competitor $competitor): Participant
    {
        if (!$this->status->isSignUp()) {
            throw new DomainException('Tournament signup period ended already or haven\'t started yet.');
        }

        if (!$this->isUniqueParticipant($competitor->getId())) {
            throw new DomainException('Competitor with such id already signed up in the tournament.');
        }

        $participant = new Participant($this, $competitor->getId(), $competitor->getName());
        $this->participants->add($participant);
        $this->updatedOn = new DateTimeImmutable();

        if ($this->participantLimitReached()) {
            $workflow->apply($this, TournamentStatus::ADJUSTMENT()->toString());
            $this->recordThat(new TournamentSignupCompleted(
                    $this->id,
                    $this->updatedOn,
                )
            );
        }

        return $participant;
    }

    public function start(WorkflowInterface $workflow): void
    {
        $this->updatedOn = new DateTimeImmutable();
        $workflow->apply($this, TournamentStatus::ONGOING()->toString());
    }

    public function finish(WorkflowInterface $workflow, CompetitorId $winnerId): void
    {
        $this->winner = $this->participantByCompetitorId($winnerId)
            ?? throw new DomainException('Participant not found');
        $this->updatedOn = new DateTimeImmutable();
        $workflow->apply($this, TournamentStatus::FINISHED()->toString());
    }

    public function participantLimitReached(): bool
    {
        return $this->participants->count() === $this->maxParticipants();
    }

    public function maxParticipants(): int
    {
        return $this->config->maxParticipants();
    }

    public function participantByCompetitorId(CompetitorId $competitorId): ?Participant
    {
        $result = $this->participants
            ->filter(static fn(Participant $participant) => $participant->is($competitorId))
            ->first();

        return false === $result ? null : $result;
    }

    // Only for workflow component support
    public function setStatus(string $status): void
    {
        $this->status = new TournamentStatus($status);
    }

    private function isUniqueParticipant(CompetitorId $competitorId): bool
    {
        return !(bool)$this->participants
            ->filter(static fn(Participant $participant) => $participant->getCompetitorId()->equals($competitorId))
            ->first();
    }
}