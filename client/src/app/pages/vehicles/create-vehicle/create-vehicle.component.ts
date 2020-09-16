import { Component, OnInit } from '@angular/core';
import { VehiclesService } from "../vehicles.service";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { Router } from '@angular/router';

@Component({
  selector: 'app-create-vehicle',
  templateUrl: './create-vehicle.component.html',
  styleUrls: ['./create-vehicle.component.css']
})
export class CreateVehicleComponent implements OnInit {
  public error: any[];
  vehicleForm: FormGroup;
  submitted = false;
  numberPattern: any = /^[0-9]+$/;

  constructor(  
    private vehicleService: VehiclesService,
    private fb: FormBuilder,
    private router: Router
  ) { }

  ngOnInit() {
    this.createFormGroup();
  }

  createFormGroup(): void {
    this.vehicleForm = this.fb.group({
      license_plate: ["", Validators.required],
      color: ["", Validators.required],
      year: ["", [Validators.required, Validators.pattern(this.numberPattern)]],
      model: ["",[Validators.required, Validators.pattern(this.numberPattern)]],
      rental_value: ["", [Validators.required, Validators.pattern(this.numberPattern)]],
    });
  }

  get f() {
    return this.vehicleForm.controls;
  }

  onSubmit() {
    this.submitted = true;
    this.vehicleService.postVehicle(this.vehicleForm.value).subscribe(
      (data) => this.handleResponse(),
      (error) => this.handleError(error)
    );
  }

  handleResponse() {
    this.submitted = false;
    this.router.navigate(["/"]);
  }

  // Implementacion para recibir los mensajes de error que llegan desde el servidor,
  // ya que la implementacion con [Validator] de Angular solo valida campos del cliente,
  // en caso de que se necesite validar un [attribute] unico, no se puede hacer, por que
  // la peticion debe de ir al servicio y regresar al cliente para poder hacer la
  // validacion y asi este devolver el mensaje de error
  handleError(error: any) {
    const resultError = error.error.errors;
    for (const key in resultError) {
      if (resultError.hasOwnProperty(key)) {
        const element = resultError[key];
        console.log(key);
        console.log(element);
      }
    }
  }

}
