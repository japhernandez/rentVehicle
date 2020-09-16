import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { environment } from "../../../environments/environment";
import { User } from "./user";
import { BehaviorSubject, Observable } from "rxjs";
import { Router } from "@angular/router";
import { map } from "rxjs/operators";

@Injectable({
  providedIn: "root",
})
export class LoginService {
  private currentUserSubject: BehaviorSubject<User>;
  public currentUser: Observable<User>;

  constructor(private httpClient: HttpClient) {
    this.currentUserSubject = new BehaviorSubject<User>(
      JSON.parse(localStorage.getItem("currentUser"))
    );
    this.currentUser = this.currentUserSubject.asObservable();
  }

  public get currentUserValue(): User {
    return this.currentUserSubject.value;
  }

  login(user: User): Observable<User> {
    return this.httpClient
      .post<User>(`${environment.baseUrl}/login`, user)
      .pipe(
        map((user) => {
          this.setUser(user);
          this.currentUserSubject.next(user);
          return user;
        })
      );
  }

  logout(): Observable<any> {
    this.currentUserSubject.next(null);
    return this.httpClient.post<any>(`${environment.baseUrl}/logout`, []);
  }

  setUser(userIn): void {
    const { user, access_token } = userIn;
    localStorage.setItem("currentUser", JSON.stringify(user));
    localStorage.setItem("token", access_token);
  }

  set(token) {
    localStorage.setItem("token", token);
  }

  get() {
    return localStorage.getItem("token");
  }

  isValid() {
    const token = this.get();
    if (token) {
      const payload = this.payload(token);
      if (payload) {
        return payload.iss === `${environment.baseUrl}/login`;
      }
    }

    return false;
  }

  payload(token) {
    const payload = token.split(".")[1];
    return this.decode(payload);
  }

  decode(payload) {
    return JSON.parse(atob(payload));
  }

  loggedIn() {
    return this.isValid();
  }
}
