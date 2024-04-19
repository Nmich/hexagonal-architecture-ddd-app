<?php

namespace App\Domain\Map;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[ORM\Entity]
#[Table(name: 'marker')]
class MarkerState
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public ?string $markerId = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(type: 'float')]
    public ?float $latitude = null;

    #[ORM\Column(type: 'float')]
    public ?float $longitude = null;

    #[ORM\Column(type: 'datetime')]
    public ?\DateTimeImmutable $addedAt = null;

    #[ORM\ManyToOne(targetEntity: MapState::class, inversedBy: 'markers')]
    #[ORM\JoinColumn(name: 'map_id', referencedColumnName: 'map_id')]
    public ?MapState $map = null;

    public function __construct(
        string $markerId = null,
        string $name = null,
        float $latitude = null,
        float $longitude = null,
        string $addedAt = null,
        MapState $map = null,
    ) {
        $this->markerId = $markerId;
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->addedAt = is_string($addedAt) ? new \DateTimeImmutable($addedAt) : $addedAt;
        $this->map = $map;
    }
}
