import { Component, OnInit } from "@angular/core";
import { LoginService } from "./pages/auth/login.service";
import { User } from "./pages/auth/user";

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html",
  styleUrls: ["./app.component.css"],
})
export class AppComponent implements OnInit {
  title = "Renta car";

  currentUser: User;

  constructor(private authService: LoginService) {
    this.authService.currentUser.subscribe((x) => (this.currentUser = x));
  }

  ngOnInit() {}
}
