import { Injectable} from '@angular/core';
import { Http, Response, Headers} from '@angular/http';
import { Observable } from 'rxjs/Rx';

@Injectable()
export class LoginService {
    private baseurl: string = 'http://localhost:9000';

    constructor (private http: Http) {}

    checkForm(obj: Object): Observable<boolean>{
        return this.http.post(`${this.baseurl}/login`,
            JSON.stringify(obj),
            {headers: this.getHeaders()})
        .map(this.extractData)
        .catch(this.handleError);
    }

    private extractData(res: Response) {
        return res.json().message;
    }

    private getHeaders(){
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        return headers;
    }

    private handleError (error: Response | any) {
        let errMsg: string;

        if (error instanceof Response) {
            const body = error.json() || '';
            const err = body.error || JSON.stringify(body);

            errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
        } else {
            errMsg = error.message ? error.message : error.toString();
        }

        console.error(errMsg);
        return Observable.throw(errMsg);
    }
}