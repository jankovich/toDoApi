<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
      * @ORM\Column(type="text", nullable=true)
    */
    private $description;

    /**
      * @ORM\Column(type="datetime")
    */
    private $createDatetime;

    /**
      * @ORM\Column(type="datetime", nullable=true)
    */
    private $doneDatetime;

    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
        $this->createDatetime = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCreateDatetime(): ?DateTime
    {
        return $this->createDatetime;
    }

    public function getDoneDatetime(): ?DateTime
    {
        return $this->doneDatetime;
    }

    public function getAsArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'createDatetime' => $this->createDatetime,
            'doneDatetime' => $this->doneDatetime,
        ];
    }

    public function done()
    {
        $this->doneDatetime = new DateTime();
    }
}
