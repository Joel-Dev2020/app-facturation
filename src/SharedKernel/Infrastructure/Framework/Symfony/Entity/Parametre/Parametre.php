<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Parametre;

use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\DatesTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\UidTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Parametre\ParametreRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ParametreRepository::class)]
#[ORM\Table(name: "parametres")]
class Parametre
{
    use UidTrait;
    use DatesTrait;

    #[Vich\UploadableField(mapping: "app", fileNameProperty: "filename")]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $filename = null;

    #[Vich\UploadableField(mapping: "app", fileNameProperty: "filename2")]
    private ?File $imageFile2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $filename2 = null;

    #[Vich\UploadableField(mapping: "app", fileNameProperty: "icon")]
    private ?File $iconFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $icon = null;

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilename2(): ?string
    {
        return $this->filename2;
    }

    public function setFilename2(?string $filename2): Parametre
    {
        $this->filename2 = $filename2;
        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): Parametre
    {
        $this->icon = $icon;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): Parametre
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new DateTimeImmutable('now');
        }
        return $this;
    }

    public function getImageFile2(): ?File
    {
        return $this->imageFile2;
    }

    public function setImageFile2(?File $imageFile2): Parametre
    {
        $this->imageFile2 = $imageFile2;
        if ($this->imageFile2 instanceof UploadedFile) {
            $this->updatedAt = new DateTimeImmutable('now');
        }
        return $this;
    }

    public function getIconFile(): ?File
    {
        return $this->iconFile;
    }

    public function setIconFile(?File $iconFile): Parametre
    {
        $this->iconFile = $iconFile;
        if ($this->iconFile instanceof UploadedFile) {
            $this->updatedAt = new DateTimeImmutable('now');
        }
        return $this;
    }

    public function __toString(): string
    {
        return 'Paramètre';
    }
}
