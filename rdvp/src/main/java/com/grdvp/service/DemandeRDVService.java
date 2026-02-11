package com.grdvp.service;

import com.grdvp.entity.DemandeRDV;
import com.grdvp.entity.Patient;
import com.grdvp.entity.Specialite;
import com.grdvp.entity.Statut;
import com.grdvp.repository.DemandeRDVRepositoryImpl;
import com.grdvp.repository.PatientRepositoryImpl;
import com.grdvp.service.interfaces.DemandeRDVServiceImpl;

import java.time.LocalDateTime;
import java.util.List;

public class DemandeRDVService implements DemandeRDVServiceImpl {

    private static DemandeRDVService instance;
    private final DemandeRDVRepositoryImpl demandeRepo;
    private final PatientRepositoryImpl patientRepo;

    private DemandeRDVService() {
        this.demandeRepo = DemandeRDVRepositoryImpl.getInstance();
        this.patientRepo = PatientRepositoryImpl.getInstance();
    }

    public static DemandeRDVService getInstance() {
        if (instance == null) {
            instance = new DemandeRDVService();
        }
        return instance;
    }

    public DemandeRDV createDemandeRDV(Patient patient, Specialite specialite, String description) {
        DemandeRDV d = new DemandeRDV();
        d.setPatient(patient);
        d.getPatient().setId(patient.getId());
        d.setSpecialite(specialite);
        d.setDescription(description);
        d.setCreatedAt(LocalDateTime.now());
        d.setStatut(Statut.EN_COURS);
        return d;
    }

    @Override
    public void addDemand(DemandeRDV demande) {
        if (demande.getCreatedAt() == null) demande.setCreatedAt(LocalDateTime.now());
        if (demande.getStatut() == null) demande.setStatut(Statut.EN_COURS);
        demandeRepo.insertDemande(demande);
    }

    @Override
    public List<DemandeRDV> searchDemand(Patient patient) {
        return demandeRepo.selectDemande(patient.getId());
    }

    @Override
    public List<DemandeRDV> searchApointment(int patientId) {
        return demandeRepo.selectAppointment(patientId);
    }

    @Override
    public List<DemandeRDV> filterDemandByStatus(String statut) {
        return demandeRepo.selectDemandeByStatut(statut);
    }


    @Override
    public void changeDemandeStatut(DemandeRDV demande, Statut statut) {
        if (demande != null && demande.getId() != null) {
            demandeRepo.updateStatut(demande.getId(), statut);
            demande.setStatut(statut);
        }
    }

    @Override
    public List<DemandeRDV> getAllDemande() {
        return demandeRepo.findAll();
    }

    @Override
    public DemandeRDV serchDemandeById(int demandeId) {
        return demandeRepo.findById(demandeId);
    }
}
