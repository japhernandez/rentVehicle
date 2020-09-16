import { NgModule } from "@angular/core";
import { Routes, RouterModule } from "@angular/router";
import { AuthGuard } from "../auth/auth.guard";
import { CreateVehicleComponent } from './create-vehicle/create-vehicle.component';
import { DetailVehicleComponent } from "./detail-vehicle/detail-vehicle.component";
import { ListVehiclesComponent } from "./list-vehicles/list-vehicles.component";

const routes: Routes = [
  {
    path: "",
    children: [
      {
        path: "",
        component: ListVehiclesComponent,
        canActivate: [AuthGuard],
      },
      {
        path: "create",
        component: CreateVehicleComponent,
        canActivate: [AuthGuard]
      },
      {
        path: "detail/:id",
        component: DetailVehicleComponent,
        canActivate: [AuthGuard],
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class VehiclesRoutingModule {}
