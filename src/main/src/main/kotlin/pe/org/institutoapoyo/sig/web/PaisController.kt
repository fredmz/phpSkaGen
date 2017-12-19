package pe.org.institutoapoyo.sig.module.ubicacion.web

import pe.org.institutoapoyo.sig.module.ubicacion.domain.Pais
import pe.org.institutoapoyo.sig.module.ubicacion.service.PaisService
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.net.URI;
import java.net.URISyntaxException;

import java.util.List;
import java.util.Optional;

/**
 * REST controller for managing Pais.
 */
@RestController
@RequestMapping("/api/ubicacion/pais")
public class PaisController(
    val paisService: PaisService
) {
    val ENTITY_NAME: String = 'pais'

    /**
    * POST  /api/ubicacion/pais : Create a new pais.
    *
    * @param pais the pais to create
    * @return the ResponseEntity with status 201 (Created) and with body the new pais, or with status 400 (Bad Request) if the pais has already an ID
    * @throws URISyntaxException if the Location URI syntax is incorrect
    */
    @PostMapping("")
    fun create(@Valid @RequestBody pais: Pais): ResponseEntity<Pais> {
        var result = paisService.create(pais);
        return ResponseEntity.created(URI("/api/ubicacion/pais/" + result.id))
            .headers(HeaderUtil.createEntityCreationAlert(ENTITY_NAME, result.id.toString()))
            .body(result);
    }

    /**
    * PUT  /api/ubicacion/pais : Updates an existing pais.
    *
    * @param pais the pais to update
    * @return the ResponseEntity with status 200 (OK) and with body the updated pais,
    * or with status 400 (Bad Request) if the pais is not valid,
    * or with status 500 (Internal Server Error) if the pais couldnt be updated
    * @throws URISyntaxException if the Location URI syntax is incorrect
    */
    @PutMapping("")
    fun update(@Valid @RequestBody Pais pais): ResponseEntity<Pais> {
        var result = paisService.update(pais);
        return ResponseEntity.ok()
            .headers(HeaderUtil.createEntityUpdateAlert(ENTITY_NAME, pais.id.toString()))
            .body(result);
    }

    /**
    * GET  /api/ubicacion/pais : get all the pais objects.
    *
    * @param pageable the pagination information
    * @return the ResponseEntity with status 200 (OK) and the list of pais objects in body
    */
    @GetMapping("")
    fun findAll(@ApiParam Pageable pageable): ResponseEntity<List<Pais>> {
        var page = paisService.findAll(pageable);
        var headers = PaginationUtil.generatePaginationHttpHeaders(page, "/api/ubicacion/pais");
        return ResponseEntity<>(page.content, headers, HttpStatus.OK);
    }

    /**
    * GET  /api/ubicacion/pais/:id : get the "id" pais.
    *
    * @param id the id of the pais to retrieve
    * @return the ResponseEntity with status 200 (OK) and with body the pais, or with status 404 (Not Found)
    */
    @GetMapping("/{id}")
    public ResponseEntity<Pais> getPais(@PathVariable Long id) {
        var pais = paisService.findOne(id);
        return ResponseUtil.wrapOrNotFound(Optional.ofNullable(pais));
    }

    /**
    * DELETE  /api/ubicacion/pais/:id : delete the "id" pais.
    *
    * @param id the id of the pais to delete
    * @return the ResponseEntity with status 200 (OK)
    */
    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deletePais(@PathVariable Long id) {
        paisService.delete(id);
        return ResponseEntity.ok().headers(HeaderUtil.createEntityDeletionAlert(ENTITY_NAME, id.toString())).build();
    }

}