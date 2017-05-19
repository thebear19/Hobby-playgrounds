import {Component, OnInit, Pipe, PipeTransform} from '@angular/core';

import {WorksService} from './work.service';

@Component({
    template: `
    <main-header (onRefresh)="ngOnInit()"></main-header>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-block row">
                    <div class="col-6">
                        <ul class="list-group">
                            <li *ngFor="let work of (works | objects)"
                            [class.active]="work.value === selectedWork"
                            class="list-group-item"
                            (click)="showWorkDetail(work.value)">
                                {{work.value.value}} #{{work.value.key}}
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <work-details [workDetails]="workdetail"></work-details>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `
})

export class DashboardComponent implements OnInit{
    works = {}
    selectedWork;
    workdetail;
    errorMessage: string = '';

    constructor(
        private worksService: WorksService
    ){}

    ngOnInit() {
        this.worksService.getWorks()
        .subscribe(p => this.works = p, e => this.errorMessage = e);
    }

    showWorkDetail(work): void{
        this.worksService.getWorkDetails(work)
        .subscribe(p => this.workdetail = p, e => this.errorMessage = e, () => this.selectedWork = work);
    }
}

@Pipe({name: 'objects'})
export class KeysPipe implements PipeTransform {
  transform(value, args:string[]) : any {
    let objects = [];
    for (let key in value) {
      objects.push({key: key, value: value[key]});
    }
    return objects;
  }
}