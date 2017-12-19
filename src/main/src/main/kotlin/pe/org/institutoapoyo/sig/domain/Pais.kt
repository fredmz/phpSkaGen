package pe.org.institutoapoyo.sig.module.ubicacion.domain

import javax.persistence.*
import org.springframework.data.jpa.repository.JpaRepository
import pe.org.institutoapoyo.sig.utils.AbstractAuditingEntity
import javax.validation.constraints.Size
import javax.validation.constraints.Min
import javax.validation.constraints.Max

data class Pais (
	@Id @GeneratedValue(strategy = GenerationType.AUTO)
	var id: Long?,


	@Column(nullable = false, maxlength = 20) @Size(min = 5, max = 20)
	var nombre: String,

	@Column(nullable = false, maxlength = 20) @Size(min = 5, max = 20)
	var apellido: String,

	@Column(nullable = false) @Min(5) @Max(20)
	var edad: Int
): AbstractAuditingEntity()

interface PaisRepository: JpaRepository<Pais, Long>