import { Component, Input, Output, OnInit, EventEmitter} from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

import {WorksService} from './work.service';

@Component({
    selector: 'new-work',
    template: `
    <div id="{{idName}}" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New work</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form [formGroup]="newWorkObj" (ngSubmit)="onAdd($event)" #newWorkForm="ngForm">
                        <div class="form-group row">
                            <label class="col-2 col-form-label text-right">Title:</label>
                            <div class="col-10">
                                <input formControlName="title" type='text' class="form-control" maxlength="50">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label text-right">Details:</label>
                            <div class="col-10">
                                <textarea formControlName="details" class="form-control" maxlength="200"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" [disabled]="newWorkObj.invalid" (click)="newWorkForm.ngSubmit.emit()">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    `
})

export class NewWorkComponent implements OnInit{
    @Input() idName: string;
    @Output() result = new EventEmitter();

    newWorkObj: FormGroup;

    errorMessage: string = '';

    constructor(
        private bean: FormBuilder,
        private worksService: WorksService
    ){}

    ngOnInit() {
        this.newWorkObj = this.bean.group({
            title: ['', Validators.required],
            details: ['', Validators.required]
        });
    }

    onAdd(): void {
        this.worksService.addNewWork(this.newWorkObj.value)
        .subscribe(p => this.result.emit(p), e => this.errorMessage = e);
    }
}