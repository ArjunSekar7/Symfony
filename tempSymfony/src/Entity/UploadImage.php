<?php

namespace App\Entity;

class UploadImage
{
    private $orginal_image_path;

    private $thumbnail_path;

    private $image;

    private $id;

    public function getOrginalImagePath(): ?string
    {
        return $this->orginal_image_path;
    }

    public function setOrginalImagePath(string $orginal_image_path): self
    {
        $this->orginal_image_path = $orginal_image_path;

        return $this;
    }

    public function getThumbnailPath(): ?string
    {
        return $this->thumbnail_path;
    }

    public function setThumbnailPath(string $thumbnail_path): self
    {
        $this->thumbnail_path = $thumbnail_path;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}
