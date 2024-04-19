<?php

namespace App\Domain\Map;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[ORM\Entity]
#[Table(name: 'map')]
class MapState
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public ?string $mapId = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'map', targetEntity: MarkerState::class, cascade: ['persist', 'remove'])]
    public Collection $markers;

    public function __construct(
        string $mapId = null,
        string $name = null,
        array $markers = []
    ) {
        $this->mapId = $mapId;
        $this->name = $name;
        $this->markers = new ArrayCollection($markers);
    }
}
