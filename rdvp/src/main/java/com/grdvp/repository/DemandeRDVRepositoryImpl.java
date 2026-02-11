package com.grdvp.repository;

import com.grdvp.config.DatabaseConnection;
import com.grdvp.entity.DemandeRDV;
import com.grdvp.entity.Specialite;
import com.grdvp.entity.Statut;
import com.grdvp.repository.interfaces.DemandeRDVRepository;

import java.sql.*;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

public class DemandeRDVRepositoryImpl implements DemandeRDVRepository {

    private static DemandeRDVRepositoryImpl instance;
    private Connection db;

    private DemandeRDVRepositoryImpl() {
        try {
            this.db = DatabaseConnection.getConnection();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static DemandeRDVRepositoryImpl getInstance() {
        if (instance == null) {
            instance = new DemandeRDVRepositoryImpl();
        }
        return instance;
    }

    
    public void insertDemande(DemandeRDV demande) {
        String sql = "INSERT INTO demande_rdv (description, patient_id, specialite, statut) VALUES (?, ?, ?::specialite_enum, ?::statut_enum) RETURNING id, created_at";

        try (PreparedStatement ps = db.prepareStatement(sql)) {
            ps.setString(1, demande.getDescription());
            int patientId = demande.getPatientId() != null ? demande.getPatientId() : (demande.getPatient() != null ? demande.getPatient().getId() : 0);
            ps.setInt(2, patientId);
            ps.setString(3, demande.getSpecialite() != null ? demande.getSpecialite().name() : null);
            ps.setString(4, demande.getStatut() != null ? demande.getStatut().name() : Statut.EN_COURS.name());
            ResultSet rs = ps.executeQuery();
            if (rs.next()) {
                demande.setId(rs.getInt("id"));
                Timestamp created = rs.getTimestamp("created_at");
                demande.setCreatedAt(created != null ? created.toLocalDateTime() : null);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    
    public List<DemandeRDV> selectDemande(int patientId) {
        return findDemandesByCondition("WHERE patient_id = ?", patientId);
    }

    
    public List<DemandeRDV> selectDemandeByStatut(String statut) {
        String sql = "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv WHERE statut = ?::statut_enum ORDER BY created_at DESC";
        List<DemandeRDV> list = new ArrayList<>();
        try (PreparedStatement ps = db.prepareStatement(sql)) {
            ps.setString(1, statut);
            ResultSet rs = ps.executeQuery();
            while (rs.next()) list.add(mapRowToDemande(rs));
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    
    public List<DemandeRDV> selectAppointment(int patientId) {
        return selectDemande(patientId);
    }

    
    public DemandeRDV findById(int demandeId) {
        String sql = "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv WHERE id = ?";
        try (PreparedStatement ps = db.prepareStatement(sql)) {
            ps.setInt(1, demandeId);
            ResultSet rs = ps.executeQuery();
            if (rs.next()) return mapRowToDemande(rs);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    
    public void updateStatut(int demandeId, Statut statut) {
        String sql = "UPDATE demande_rdv SET statut = ?::statut_enum WHERE id = ?";
        try (PreparedStatement ps = db.prepareStatement(sql)) {
            ps.setString(1, statut.name());
            ps.setInt(2, demandeId);
            ps.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    
    public List<DemandeRDV> findAll() {
        return findDemandesByCondition("", null);
    }

    private List<DemandeRDV> findDemandesByCondition(String whereClause, Integer patientId) {
        String sql = whereClause.isEmpty()
            ? "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv ORDER BY created_at DESC"
            : "SELECT id, description, created_at, patient_id, specialite, statut FROM demande_rdv " + whereClause + " ORDER BY created_at DESC";
        List<DemandeRDV> list = new ArrayList<>();
        try (PreparedStatement ps = db.prepareStatement(sql)) {
            if (patientId != null) ps.setInt(1, patientId);
            ResultSet rs = ps.executeQuery();
            while (rs.next()) list.add(mapRowToDemande(rs));
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    private DemandeRDV mapRowToDemande(ResultSet rs) throws SQLException {
        DemandeRDV d = new DemandeRDV();
        d.setId(rs.getInt("id"));
        d.setDescription(rs.getString("description"));
        Timestamp created = rs.getTimestamp("created_at");
        d.setCreatedAt(created != null ? created.toLocalDateTime() : null);
        d.setPatientId(rs.getInt("patient_id"));
        String spec = rs.getString("specialite");
        d.setSpecialite(spec != null ? Specialite.valueOf(spec) : null);
        String st = rs.getString("statut");
        d.setStatut(st != null ? Statut.valueOf(st) : null);
        return d;
    }
}
