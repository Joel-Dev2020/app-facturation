<?php

namespace App\SharedKernel\Domain\Entity\Parametre;

class Parametre
{
    public readonly ?string $id;
    private ?string $filename;
    private ?string $filename2;
    private ?string $icon;
    private mixed $imageFile;
    private mixed $imageFile2;
    private mixed $iconFile;

    public function __construct(
        ?string $id = null,
        ?string $filename = null,
        ?string $filename2 = null,
        ?string $icon = null,
        mixed   $imageFile = null,
        mixed   $imageFile2 = null,
        mixed   $iconFile = null
    )
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->filename2 = $filename2;
        $this->icon = $icon;
        $this->imageFile = $imageFile;
        $this->imageFile2 = $imageFile2;
        $this->iconFile = $iconFile;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): Parametre
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

    public function getImageFile(): mixed
    {
        return $this->imageFile;
    }

    public function setImageFile(mixed $imageFile): Parametre
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getImageFile2(): mixed
    {
        return $this->imageFile2;
    }

    public function setImageFile2(mixed $imageFile2): Parametre
    {
        $this->imageFile2 = $imageFile2;
        return $this;
    }

    public function getIconFile(): mixed
    {
        return $this->iconFile;
    }

    public function setIconFile(mixed $iconFile): Parametre
    {
        $this->iconFile = $iconFile;
        return $this;
    }
}