import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
import { LoginService } from "../../pages/auth/login.service";

@Component({
  selector: "app-nav-bar",
  templateUrl: "./nav-bar.component.html",
  styleUrls: ["./nav-bar.component.css"],
})
export class NavBarComponent implements OnInit {
  constructor(private authService: LoginService, private router: Router) {}

  ngOnInit() {}

  logout() {
    this.authService.logout().subscribe((res) => {
      localStorage.removeItem("token");
      localStorage.removeItem("currentUser");
      this.router.navigate(["/login"]);
    });
  }
}
