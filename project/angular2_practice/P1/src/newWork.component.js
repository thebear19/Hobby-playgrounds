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
var work_service_1 = require("./work.service");
var NewWorkComponent = (function () {
    function NewWorkComponent(bean, worksService) {
        this.bean = bean;
        this.worksService = worksService;
        this.result = new core_1.EventEmitter();
        this.errorMessage = '';
    }
    NewWorkComponent.prototype.ngOnInit = function () {
        this.newWorkObj = this.bean.group({
            title: ['', forms_1.Validators.required],
            details: ['', forms_1.Validators.required]
        });
    };
    NewWorkComponent.prototype.onAdd = function () {
        var _this = this;
        this.worksService.addNewWork(this.newWorkObj.value)
            .subscribe(function (p) { return _this.result.emit(p); }, function (e) { return _this.errorMessage = e; });
    };
    return NewWorkComponent;
}());
__decorate([
    core_1.Input(),
    __metadata("design:type", String)
], NewWorkComponent.prototype, "idName", void 0);
__decorate([
    core_1.Output(),
    __metadata("design:type", Object)
], NewWorkComponent.prototype, "result", void 0);
NewWorkComponent = __decorate([
    core_1.Component({
        selector: 'new-work',
        template: "\n    <div id=\"{{idName}}\" class=\"modal fade\">\n        <div class=\"modal-dialog\" role=\"document\">\n            <div class=\"modal-content\">\n                <div class=\"modal-header\">\n                    <h5 class=\"modal-title\">New work</h5>\n                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n                        <span aria-hidden=\"true\">&times;</span>\n                    </button>\n                </div>\n                <div class=\"modal-body\">\n                    <form [formGroup]=\"newWorkObj\" (ngSubmit)=\"onAdd($event)\" #newWorkForm=\"ngForm\">\n                        <div class=\"form-group row\">\n                            <label class=\"col-2 col-form-label text-right\">Title:</label>\n                            <div class=\"col-10\">\n                                <input formControlName=\"title\" type='text' class=\"form-control\" maxlength=\"50\">\n                            </div>\n                        </div>\n\n                        <div class=\"form-group row\">\n                            <label class=\"col-2 col-form-label text-right\">Details:</label>\n                            <div class=\"col-10\">\n                                <textarea formControlName=\"details\" class=\"form-control\" maxlength=\"200\"></textarea>\n                            </div>\n                        </div>\n                    </form>\n                </div>\n                <div class=\"modal-footer\">\n                    <button type=\"button\" class=\"btn btn-primary\" [disabled]=\"newWorkObj.invalid\" (click)=\"newWorkForm.ngSubmit.emit()\">Add</button>\n                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>\n                </div>\n            </div>\n        </div>\n    </div>\n    "
    }),
    __metadata("design:paramtypes", [forms_1.FormBuilder,
        work_service_1.WorksService])
], NewWorkComponent);
exports.NewWorkComponent = NewWorkComponent;
//# sourceMappingURL=newWork.component.js.map