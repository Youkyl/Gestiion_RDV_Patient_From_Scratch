<?php

namespace App\entity;

use DateTime;

class DemandeRDV
{
    private int $id;
    private string $descriptiion;
    private DateTime $createAt;
    private Patient $patient;
    private Specialite $specialite;
    private Statut $statut;

    public function __construct(
        Patient $patient,
        Specialite $specialite,
        int | null $id = null,
        string | null $descriptiion = null,
        DateTime | null $createAt = null,
        Statut | null $statut = null
    )
    {
        $this->id = $id ?? 0;
        $this->descriptiion = $descriptiion;
        $this->createAt = $createAt;
        $this->patient = $patient;
        $this->specialite = $specialite;
        $this->statut = $statut;
    }

    
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescriptiion(): ?string
    {
        return $this->descriptiion;
    }

    public function setDescriptiion(?string $descriptiion): void
    {
        $this->descriptiion = $descriptiion;
    }

    public function getCreateAt(): ?DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(?DateTime $createAt): void
    {
        $this->createAt = $createAt;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): void
    {
        $this->patient = $patient;
    }

    public function getSpecialite(): Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): void
    {
        $this->statut = $statut;
    }

    public function __toString(): string
    {
        $createAtString = $this->createAt ? $this->createAt->format('Y-m-d H:i:s') : 'null';
        $patientString = method_exists($this->patient, '__toString') ? (string) $this->patient : 'Patient';
        $specialiteString = method_exists($this->specialite, '__toString') ? (string) $this->specialite : 'Specialite';
        $statutString = $this->statut && method_exists($this->statut, '__toString') ? (string) $this->statut : 'null';

        return sprintf(
            "DemandeRDV { id: %d, descriptiion: %s, createAt: %s, patient: %s, specialite: %s, statut: %s }",
            $this->id,
            $this->descriptiion ?? 'null',
            $createAtString,
            $patientString,
            $specialiteString,
            $statutString
        );
    }
}