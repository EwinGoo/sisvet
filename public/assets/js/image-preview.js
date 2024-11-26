class ImageUploader {
  constructor() {
    this.uploadArea = document.getElementById("uploadArea");
    this.placeholder = document.getElementById("placeholder");
    this.fileInput = document.getElementById("fileInput");
    this.maxFileSize = 5 * 1024 * 1024; // 5MB
    this.acceptedTypes = ["image/jpeg", "image/png", "image/gif"];
    this.currentFitMode = "contain"; // contain o cover

    this.initializeEventListeners();

    // this.loadDefaultImage();
  }

  loadDefaultImage() {
    // Creamos un objeto Blob con una imagen base64 o cargamos una URL
    this.loadImageFromURL("./maestro.jpg");
  }

  // Nuevo método para cargar imagen desde URL
  loadImageFromURL(url) {
    
    this.removeImage();
    if(!url) return;
    // Mostrar loading mientras se carga la imagen
    const loadingOverlay = document.createElement("div");
    loadingOverlay.className = "loading-overlay";
    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
    this.uploadArea.appendChild(loadingOverlay);

    // Crear un objeto Image para cargar la imagen
    const img = new Image();

    img.onload = () => {
      // Convertir la imagen a Blob
      fetch(url)
        .then((response) => response.blob())
        .then((blob) => {
          // Crear un objeto File a partir del Blob
          const file = new File([blob], "default-image.jpg", {
            type: "image/jpeg",
          });

          // Mostrar la imagen usando el método existente
          this.showImage(file);
          loadingOverlay.remove();
        })
        .catch((error) => {
          console.error("Error cargando la imagen:", error);
          loadingOverlay.remove();
        });
    };

    img.onerror = () => {
      console.error("Error cargando la imagen");
      loadingOverlay.remove();
    };

    img.src = url;
  }

  // Método para cargar imagen manualmente (puedes llamarlo desde fuera de la clase)
  loadImage(imageUrl) {
    this.loadImageFromURL(imageUrl);
  }

  initializeEventListeners() {
    this.uploadArea.addEventListener("click", (e) => {
      // No activar el input si se hace clic en los botones
      if (e.target.closest(".remove-button")) {
        return;
      }
      this.fileInput.click();
    });

    this.fileInput.addEventListener("change", (e) =>
      this.handleFile(e.target.files[0])
    );

    this.uploadArea.addEventListener("dragover", (e) => {
      e.preventDefault();
      this.placeholder.classList.add("drag-over");
    });

    this.uploadArea.addEventListener("dragleave", () => {
      this.placeholder.classList.remove("drag-over");
    });

    this.uploadArea.addEventListener("drop", (e) => {
      e.preventDefault();
      this.placeholder.classList.remove("drag-over");
      this.handleFile(e.dataTransfer.files[0]);
    });
  }

  handleFile(file) {
    if (!file) return;
    if (!this.validateFile(file)) return;
    this.showImage(file);
  }

  validateFile(file) {
    if (!this.acceptedTypes.includes(file.type)) {
      this.showError("Solo se permiten archivos de imagen (JPEG, PNG, GIF)");
      return false;
    }
    if (file.size > this.maxFileSize) {
      this.showError("El archivo es demasiado grande. Máximo 5MB");
      return false;
    }
    return true;
  }

  showError(message) {
    const existingError = document.querySelector(".error-message");
    if (existingError) existingError.remove();

    const error = document.createElement("div");
    error.className = "error-message";
    error.textContent = message;
    this.uploadArea.insertAdjacentElement("afterend", error);
    setTimeout(() => error.remove(), 3000);
  }

  showImage(file) {
    const loadingOverlay = document.createElement("div");
    loadingOverlay.className = "loading-overlay";
    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
    this.uploadArea.appendChild(loadingOverlay);

    const reader = new FileReader();
    reader.onload = (e) => {
      this.placeholder.style.display = "none";
      loadingOverlay.remove();

      let imageContainer = this.uploadArea.querySelector(".preview-container");
      if (!imageContainer) {
        imageContainer = document.createElement("div");
        imageContainer.className = "preview-container";
        this.uploadArea.appendChild(imageContainer);
      }

      imageContainer.innerHTML = `
                        <img src="${e.target.result}" class="preview-image" alt="${file.name}" style="object-fit: ${this.currentFitMode}">
                        <button class="remove-button">x</button>
                    `;

      // Evento para eliminar
      const removeButton = imageContainer.querySelector(".remove-button");
      removeButton.addEventListener("click", (e) => {
        e.stopPropagation();
        this.removeImage();
      });

      // Eventos para los botones de ajuste
      const fitButtons = imageContainer.querySelectorAll(
        ".image-control-button"
      );
      fitButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
          e.stopPropagation();
          this.currentFitMode = button.dataset.mode;
          const image = imageContainer.querySelector(".preview-image");
          image.style.objectFit = this.currentFitMode;
          fitButtons.forEach((btn) =>
            btn.classList.toggle("active", btn === button)
          );
        });
      });
    };
  

    reader.readAsDataURL(file);
  }
  removeImage(){
    let imageContainer = this.uploadArea.querySelector(".preview-container");
    if(!imageContainer) return;
    imageContainer.remove();
    this.placeholder.style.display = "flex";
    this.fileInput.value = "";
  }
}
// Inicializar el uploader
// new ImageUploader();
const imageUploader = new ImageUploader();
