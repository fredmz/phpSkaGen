import {HttpParams} from "@angular/common/http";

export const createRequestOption = (req?: any): HttpParams => {
    let options: HttpParams = new HttpParams();
    if (req) {
        options = options.set('page', req.page);
        options = options.set('size', req.size);
        if (req.sort) {
            req.sort.forEach((sort)=>{
                options = options.append('sort', sort)
            });
        }
        if (req.query) {
            options = options.set('query', req.query);
        }
        if (req.filtros) {
            for (const parametro in req.filtros) {
                if (req.filtros.hasOwnProperty(parametro)) {
                    if (req.filtros[parametro] !== undefined) {
                        if (typeof req.filtros[parametro] === 'object') {
                            if (req.filtros[parametro].length > 0) {
                                options.set(parametro, req.filtros[parametro]);
                            }
                        } else {
                            options.set(parametro, req.filtros[parametro]);
                        }
                    }
                }
            }
        }
    }
    return options;
};
