import { Component, OnInit } from "@angular/core";
import { VehiclesInterface } from "../vehicles-interface";
import { VehiclesService } from "../vehicles.service";

@Component({
  selector: "app-list-vehicles",
  templateUrl: "./list-vehicles.component.html",
  styleUrls: ["./list-vehicles.component.css"],
})
export class ListVehiclesComponent implements OnInit {
  user: string;
  vehiclesArray: VehiclesInterface;

  constructor(
    private vehicleService: VehiclesService,
  ) {
    this.user = JSON.parse(localStorage.getItem("currentUser"));
  }

  ngOnInit() {
    this.vehicles();
  }

  vehicles() {
    this.vehicleService.getVehicles().subscribe((res) => {
      this.vehiclesArray = res;
    });
  }

  deleteVehicle(id: number) {
    this.vehicleService.deleteVehicle(id).subscribe(() => {
      this.vehicles();
    });
  }
}
