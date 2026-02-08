<?php

namespace App\entity;

use DateTime;

class Patient
{
    private ?int $id;
    private string $patientCode;
    private string $lastname;
    private string $firstname;
    private string $address;
    private string $phone;
    private array $medicalHistory;
    private string $email;
    private string $password;
    private DateTime $birthday;
    private DateTime $creatAt;
    private array $demandes;

    public function __construct(
        int | null $id = null,
        string | null $patientCode = null,
        string $lastname,
        string $firstname,
        string | null $address = null,
        string | null $phone = null,
        array | null $medicalHistory = null,
        string $email,
        string $password,
        DateTime $birthday,
        DateTime | null $creatAt = null,
        array | null $demandes = null
    )
    {
        $this->id = $id;
        $this->patientCode = $patientCode;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->address = $address;
        $this->phone = $phone;
        $this->medicalHistory = $medicalHistory; 
        $this->email = $email;
        $this->password = $password; 
        $this->birthday = $birthday;
        $this->creatAt = $creatAt;
        $this->demandes = $demandes;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPatientCode(): string
    {
        return $this->patientCode;
    }
    
    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
    
    public function getMedicalHistory(): array
    {
        return $this->medicalHistory;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getBirthday(): DateTime
    {
        return $this->birthday;
    }
    
    public function getCreatAt(): DateTime
    {
        return $this->creatAt;
    }
    
    public function getDemandes(): array
    {
        return $this->demandes;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPatientCode(string $patientCode): void
    {
        $this->patientCode = $patientCode;
    }
    
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }
    
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
    
    
    public function setMedicalHistory(array $medicalHistory): void
    {
        $this->medicalHistory = $medicalHistory;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setBirthday(DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }
    
    public function setCreatAt(DateTime $creatAt): void
    {
        $this->creatAt = $creatAt;
    }

    public function setDemandes(array $demandes): void
    {
        $this->demandes = $demandes;
    }

    
    /**
     * @return string
    */

    public function __toString(): string
    {
        return $this->lastname . ' ' . $this->firstname . ' ' . $this->address . ' ' . $this->phone . ' ' . $this->medicalHistory . ' ' . $this->email . ' ' . $this->password . ' ' . $this->birthday . ' ' . $this->creatAt . ' ' . $this->demandes;
    }
}