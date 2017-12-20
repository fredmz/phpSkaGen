package pe.org.institutoapoyo.sig.module.ubicacion.service

import pe.org.institutoapoyo.sig.module.ubicacion.domain.Pais
import pe.org.institutoapoyo.sig.module.ubicacion.domain.PaisRepository
import org.springframework.data.domain.Page
import org.springframework.data.domain.Pageable
import org.springframework.transaction.annotation.Transactional
import org.springframework.stereotype.Service

@Service
@Transactional
class PaisService(
    val paisRepository: PaisRepository
) {

    /**
    * Create a pais.
    *
    * @param pais the entity to save
    * @return the persisted entity
    */
    fun create(pais: Pais): Pais {
        if (pais.id > 0) {
            throw RuntimeException("No se puede crear un objecto que ya existe")
        }
        return paisRepository.save(pais)
    }

    /**
    * Update a pais.
    *
    * @param pais the entity to save
    * @return the persisted entity
    */
    fun update(pais: Pais): Pais {
        if (pais.id == null || pais.id == 0) {
            throw RuntimeException("No se puede actualizar un objeto que no existe")
        }
        return paisRepository.save(pais)
    }

    /**
    *  Get one pais by id.
    *
    *  @param id the id of the entity
    *  @return the entity
    */
    @Transactional(readOnly = true)
    fun findOne(id: Long): Pais {
        return paisRepository.findOne(id)
    }

    @Transactional(readOnly = true)
    fun findAll(pageable: Pageable): Page<Pais>
        return paisRepository.findAll(pageable)

    /**
    *  Delete the {{pais}} by id.
    *
    *  @param id the id of the entity
    */
    fun delete(id: Long) {
        paisRepository.delete(id)
    }
}