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
var forms_1 = require("@angular/forms");
var router_1 = require("@angular/router");
var login_service_1 = require("./login.service");
var LoginFormComponent = (function () {
    function LoginFormComponent(bean, loginService, router) {
        this.bean = bean;
        this.loginService = loginService;
        this.router = router;
        this.labelSize = 3;
        this.inputSize = 9;
        this.errorMessage = '';
    }
    LoginFormComponent.prototype.ngOnInit = function () {
        this.loginObj = this.bean.group({
            usernameBox: ['', forms_1.Validators.required],
            passwordBox: ['', forms_1.Validators.required]
        });
    };
    LoginFormComponent.prototype.onLogin = function () {
        var _this = this;
        this.loginService.checkForm(this.loginObj.value)
            .subscribe(function (p) { return _this.isvalid = p; }, function (e) { return _this.errorMessage = e; }, function () { return _this.onLogined(); });
    };
    LoginFormComponent.prototype.onLogined = function () {
        if (this.isvalid) {
            this.router.navigate(['/main']);
        }
    };
    return LoginFormComponent;
}());
LoginFormComponent = __decorate([
    core_1.Component({
        template: "\n    <div class=\"row justify-content-center\" style=\"padding-top: 20%\">\n        <div class=\"col-5\">\n            <div class=\"card\">\n                <div class=\"card-block\">\n                    <alert message=\"ERROR!!\" *ngIf=\"isvalid === false\"></alert>\n                    <h3>Login</h3>\n                    <form [formGroup]=\"loginObj\" (ngSubmit)=\"onLogin($event)\">\n                        <div class=\"form-group row\">\n                            <label for=\"username\" class=\"col-{{labelSize}} col-form-label text-right\">Username:</label>\n                            <div class=\"col-{{inputSize}}\">\n                                <input formControlName=\"usernameBox\" type='text' class=\"form-control\" maxlength=\"20\">\n                            </div>\n                        </div>\n\n                        <div class=\"form-group row\">\n                            <label for=\"username\" class=\"col-{{labelSize}} col-form-label text-right\">Password:</label>\n                            <div class=\"col-{{inputSize}}\">\n                                <input formControlName=\"passwordBox\" type='password' class=\"form-control\" maxlength=\"10\">\n                            </div>\n                        </div>\n\n                        <div class=\"form-group row\">\n                            <div class=\"col-12\">\n                                <button type=\"submit\" [disabled]=\"loginObj.invalid\" class=\"btn btn-primary offset-md-4 col-3\">Login</button>\n                            </div>\n                        </div>\n                    </form>\n                </div>\n            </div>\n        </div>\n    </div>\n    "
    }),
    __metadata("design:paramtypes", [forms_1.FormBuilder,
        login_service_1.LoginService,
        router_1.Router])
], LoginFormComponent);
exports.LoginFormComponent = LoginFormComponent;
//# sourceMappingURL=loginForm.component.js.map