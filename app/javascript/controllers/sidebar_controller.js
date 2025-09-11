import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="sidebar"
export default class extends Controller {
  static targets = ["sidebar", "overlay"]
  connect() {
  }

  toggle() {
    this.sidebarTarget.classList.toggle("-translate-x-full")
    this.overlayTarget.classList.toggle("hidden")
  }
}
