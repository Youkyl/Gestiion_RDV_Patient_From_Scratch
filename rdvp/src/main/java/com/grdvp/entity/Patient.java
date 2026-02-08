package com.grdvp.entity;

import java.time.LocalDate;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.Objects;

public class Patient {
    private Integer id;
    private String patientCode;
    private String lastname;
    private String firstname;
    private String address;
    private String phone;
    private List<String> medicalHistory;
    private String email;
    private String password;
    private LocalDate birthday;
    private LocalDateTime createdAt;
    private List<DemandeRDV> demandes;

    public Patient(
            Integer id,
            String patientCode,
            String lastname,
            String firstname,
            String address,
            String phone,
            List<String> medicalHistory,
            String email,
            String password,
            LocalDate birthday,
            LocalDateTime createdAt,
            List<DemandeRDV> demandes
    ) {
        this.id = id;
        this.patientCode = patientCode;
        this.lastname = lastname;
        this.firstname = firstname;
        this.address = address;
        this.phone = phone;
        this.medicalHistory = medicalHistory != null ? medicalHistory : new ArrayList<>();
        this.email = email;
        this.password = password;
        this.birthday = birthday;
        this.createdAt = createdAt;
        this.demandes = demandes;
    }

    public Patient() {
        this.medicalHistory = new ArrayList<>();
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getPatientCode() {
        return patientCode;
    }

    public void setPatientCode(String patientCode) {
        this.patientCode = patientCode;
    }

    public String getLastname() {
        return lastname;
    }

    public void setLastname(String lastname) {
        this.lastname = lastname;
    }

    public String getFirstname() {
        return firstname;
    }

    public void setFirstname(String firstname) {
        this.firstname = firstname;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public List<String> getMedicalHistory() {
        return medicalHistory;
    }

    public void setMedicalHistory(List<String> medicalHistory) {
        this.medicalHistory = medicalHistory;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public LocalDate getBirthday() {
        return birthday;
    }

    public void setBirthday(LocalDate birthday) {
        this.birthday = birthday;
    }

    public LocalDateTime getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(LocalDateTime createdAt) {
        this.createdAt = createdAt;
    }

    public List<DemandeRDV> getDemandes() {
        return demandes;
    }


    @Override
    public String toString() {
        return String.format(
            "%s %s %s %s %s %s %s %s %s %s %s",
            Objects.toString(lastname, ""),
            Objects.toString(firstname, ""),
            Objects.toString(address, ""),
            Objects.toString(phone, ""),
            Objects.toString(medicalHistory, ""),
            Objects.toString(email, ""),
            Objects.toString(password, ""),
            Objects.toString(birthday, ""),
            Objects.toString(createdAt, ""),
            Objects.toString(demandes, ""),
            Objects.toString(patientCode, "")
        );
    }
}