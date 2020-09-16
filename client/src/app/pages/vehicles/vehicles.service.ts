import { Injectable } from "@angular/core";
import { environment } from "../../../environments/environment";
import { HttpClient } from "@angular/common/http";
import { Observable } from "rxjs";
import { VehiclesInterface } from "./vehicles-interface";
import { RentInterface } from "./rent-interface";

@Injectable({
  providedIn: "root",
})
export class VehiclesService {
  constructor(private http: HttpClient) {}

  getVehicles(): Observable<VehiclesInterface> {
    return this.http.get<VehiclesInterface>(`${environment.baseUrl}/vehicles`);
  }

  getDetailVehicle(id: number): Observable<VehiclesInterface> {
    return this.http.get<VehiclesInterface>(
      `${environment.baseUrl}/vehicles/${id}`
    );
  }

  postVehicle(data: VehiclesInterface): Observable<VehiclesInterface> {
    return this.http.post<VehiclesInterface>(`${environment.baseUrl}/vehicle`, data);
  }

  deleteVehicle(id: number): Observable<VehiclesInterface> {
    return this.http.delete<VehiclesInterface>(
      `${environment.baseUrl}/vehicles/${id}`
    );
  }

  postRental(rent: RentInterface): Observable<RentInterface> {
    return this.http.post<RentInterface>(`${environment.baseUrl}/rents`, rent);
  }
}
