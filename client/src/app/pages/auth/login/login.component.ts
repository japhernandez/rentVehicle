import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { Router } from "@angular/router";
import { BehaviorSubject } from "rxjs";
import { LoginService } from "../login.service";

@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.css"],
})
export class LoginComponent implements OnInit {
  public loginForm: FormGroup;
  submitted = false;
  errors;

  constructor(
    private authService: LoginService,
    private router: Router,
    private formBuilder: FormBuilder
  ) {}

  // tslint:disable-next-line:use-lifecycle-interface
  ngOnInit() {
    this.loginForm = this.formBuilder.group({
      email: ["", [Validators.required, Validators.email]],
      password: ["", Validators.required],
    });
  }

  get f() {
    return this.loginForm.controls;
  }

  onSubmit() {
    this.submitted = true;
    if (this.loginForm.invalid) {
      return;
    }
    this.authService.login(this.loginForm.value).subscribe(
      (data) => this.handleResponse(data),
      (error) => this.handleError(error)
    );
  }

  handleResponse(data) {
    this.authService.setUser(data);
    this.router.navigate(["/home"]);
  }

  handleError(error) {
    console.log(error.status);
    if (error.status === 401) {
      this.errors = "La credenciales no son correctas";
    }
  }
}
