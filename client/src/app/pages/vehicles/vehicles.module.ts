import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { VehiclesRoutingModule } from './vehicles-routing.module';
import { ListVehiclesComponent } from './list-vehicles/list-vehicles.component';
import { DetailVehicleComponent } from './detail-vehicle/detail-vehicle.component';
import { CreateVehicleComponent } from './create-vehicle/create-vehicle.component';


@NgModule({
  declarations: [ListVehiclesComponent, DetailVehicleComponent, CreateVehicleComponent],
  imports: [
    CommonModule,
    VehiclesRoutingModule,
    FormsModule, ReactiveFormsModule
  ]
})
export class VehiclesModule { }
