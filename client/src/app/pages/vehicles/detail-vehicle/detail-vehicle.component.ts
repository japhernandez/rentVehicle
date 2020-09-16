import { Component, OnInit } from "@angular/core";
import { Router, ActivatedRoute } from "@angular/router";
import { VehiclesService } from "../vehicles.service";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { VehiclesInterface } from "../vehicles-interface";
import * as moment from "moment";

@Component({
  selector: "app-detail-vehicle",
  templateUrl: "./detail-vehicle.component.html",
  styleUrls: ["./detail-vehicle.component.css"],
})
export class DetailVehicleComponent implements OnInit {
  public error: any[];
  rentForm: FormGroup;
  submitted = false;
  vehicle: VehiclesInterface;
  valueRent: number;
  calculate;
  user: {};
  paramId: number;

  constructor(
    private vehicleService: VehiclesService,
    private router: Router,
    private activatedRoute: ActivatedRoute,
    private fb: FormBuilder
  ) {
    this.paramId = this.activatedRoute.snapshot.params.id;
    this.getDetail(this.paramId);
    this.createFormGroup();
  }

  ngOnInit() {
    this.user = JSON.parse(localStorage.getItem("currentUser"));
  }

  getDetail(id: number) {
    return this.vehicleService.getDetailVehicle(id).subscribe((res) => {
      this.vehicle = res;
      this.valueRent = res.rental_value;
    });
  }

  createFormGroup() {
    this.rentForm = this.fb.group({
      delivery_date: ["", Validators.required],
      departure_date: ["", Validators.required],
      payment_method: ["", Validators.required],
    });
  }

  get f() {
    return this.rentForm.controls;
  }

  onSubmit() {
    if (this.calculate <= 0) {
      alert('La fecha de entrega debe ser mayor');
      return;
    }
    const user = JSON.parse(localStorage.getItem("currentUser"));
    const objectData = {};
    objectData["user_id"] = user.id;
    objectData["vehicle_id"] = this.paramId;
    const dataForm = Object.assign(objectData, this.rentForm.value);
    this.submitted = true;
    this.vehicleService.postRental(dataForm).subscribe(
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

  calculateRent(event: { id: string; value: any }) {
    let initial: moment.MomentInput;
    let end: moment.MomentInput;

    if (event.id === "delivery_date") initial = event.value;
    if (event.id === "departure_date") end = event.value;

    const initialDate = moment(initial);
    const endDate = moment(end);
    const date = endDate.diff(initialDate, "days") + 2;
    if (date < 0) {
      alert('La fecha de entrega debe ser mayor')
      this.calculate = 0;
      return;
    }
    if (end && date > 0) this.calculate = date * this.valueRent;
  }
}
