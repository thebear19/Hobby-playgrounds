"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require("@angular/core");
var http_1 = require("@angular/http");
var Rx_1 = require("rxjs/Rx");
var WorksService = (function () {
    function WorksService(http) {
        this.http = http;
        this.baseurl = 'http://localhost:9000';
    }
    WorksService.prototype.getWorks = function () {
        return this.http.get(this.baseurl + "/works", { headers: this.getHeaders() })
            .map(this.extractData)
            .catch(this.handleError);
    };
    WorksService.prototype.getWorkDetails = function (work) {
        return this.http.get(this.baseurl + "/workDetails/" + work.key, { headers: this.getHeaders() })
            .map(this.extractData)
            .catch(this.handleError);
    };
    WorksService.prototype.addNewWork = function (obj) {
        return this.http.post(this.baseurl + "/addNewWork", JSON.stringify(obj), { headers: this.getHeaders() })
            .map(this.extractData)
            .catch(this.handleError);
    };
    WorksService.prototype.extractData = function (res) {
        return res.json();
    };
    WorksService.prototype.getHeaders = function () {
        var headers = new http_1.Headers();
        headers.append('Content-Type', 'application/json');
        return headers;
    };
    WorksService.prototype.handleError = function (error) {
        var errMsg;
        if (error instanceof http_1.Response) {
            var body = error.json() || '';
            var err = body.error || JSON.stringify(body);
            errMsg = error.status + " - " + (error.statusText || '') + " " + err;
        }
        else {
            errMsg = error.message ? error.message : error.toString();
        }
        console.error(errMsg);
        return Rx_1.Observable.throw(errMsg);
    };
    return WorksService;
}());
WorksService = __decorate([
    core_1.Injectable(),
    __metadata("design:paramtypes", [http_1.Http])
], WorksService);
exports.WorksService = WorksService;
//# sourceMappingURL=work.service.js.map