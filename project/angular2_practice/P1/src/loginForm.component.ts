import {Component, OnInit} from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

import {LoginService} from './login.service';

@Component({
    template: `
    <div class="row justify-content-center" style="padding-top: 20%">
        <div class="col-5">
            <div class="card">
                <div class="card-block">
                    <alert message="ERROR!!" *ngIf="isvalid === false"></alert>
                    <h3>Login</h3>
                    <form [formGroup]="loginObj" (ngSubmit)="onLogin($event)">
                        <div class="form-group row">
                            <label for="username" class="col-{{labelSize}} col-form-label text-right">Username:</label>
                            <div class="col-{{inputSize}}">
                                <input formControlName="usernameBox" type='text' class="form-control" maxlength="20">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-{{labelSize}} col-form-label text-right">Password:</label>
                            <div class="col-{{inputSize}}">
                                <input formControlName="passwordBox" type='password' class="form-control" maxlength="10">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <button type="submit" [disabled]="loginObj.invalid" class="btn btn-primary offset-md-4 col-3">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    `
})

export class LoginFormComponent implements OnInit{
    labelSize = 3;
    inputSize = 9;

    loginObj: FormGroup;

    isvalid: boolean;
    errorMessage: string = '';

    constructor(
        private bean: FormBuilder,
        private loginService: LoginService,
        private router: Router
    ){}

    ngOnInit() {
        this.loginObj = this.bean.group({
            usernameBox: ['', Validators.required],
            passwordBox: ['', Validators.required]
        });
    }

    onLogin(): void {
        this.loginService.checkForm(this.loginObj.value)
        .subscribe(p => this.isvalid = p, e => this.errorMessage = e, () => this.onLogined());
    }

    onLogined(): void{
        if(this.isvalid){
            this.router.navigate(['/main']);
        }
    }
}