import { Component, Output, EventEmitter } from '@angular/core';

declare var $: any;

@Component({
    selector: 'main-header',
    template: `
    <nav class="navbar navbar-inverse bg-inverse navbar-toggleable-md">
        <a class="navbar-brand" href="#">A2</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" (click)="showNewWork($event)">New</a>
                </li>
            </ul>

            <ul class="navbar-nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="/login">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <new-work [idName]="id_workLabel" (result)="closeNewWork($event)"></new-work>
    `
})

export class MainHeaderComponent {
    @Output() onRefresh = new EventEmitter();

    id_workLabel :string = "addNewWork"

    constructor() {}

    showNewWork(event){
        event.preventDefault();

        $('#addNewWork').modal({
            backdrop: "static"
        });
    }

    closeNewWork(event){
        $('#addNewWork').modal('hide');
        this.onRefresh.emit(true);
    }
}