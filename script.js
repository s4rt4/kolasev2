let currentPage = 1;
const limit = 20;
let lastParams = {};
let msnry;
let lgInstance;

// Acak array
function shuffleArray(arr) {
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
}

// Init / Reinit LightGallery
function initLightGallery() {
  const gallery = document.getElementById("gallery");
  if (lgInstance) {
    lgInstance.destroy(true);
  }

  lgInstance = lightGallery(gallery, {
    selector: ".gallery-item a",
    plugins: [
      lgZoom,
      lgThumbnail,
      lgFullscreen,
      lgAutoplay,
    ],
    licenseKey: "my-dev-key",
    speed: 500,
    download: true,

    // ✅ Perbaikan toolbar & close button
    controls: true,
    showCloseIcon: true,
    closable: true, // supaya klik ikon plugin gak langsung nutup popup
    slideShowAutoplay: false
  });
}


async function loadGallery(params = {}, append = false) {
  lastParams = params;
  const query = new URLSearchParams({ ...params, page: currentPage, limit }).toString();

  let photos = [];
  try {
    const res = await fetch("api.php?" + query);
    photos = await res.json();
  } catch (err) {
    console.error("Gagal ambil data dari API:", err);
    return;
  }

  const gallery = document.getElementById("gallery");

  if (!append) {
    shuffleArray(photos);
    gallery.innerHTML = '<div class="grid-sizer"></div>';
  }

  const newElems = [];
  photos.forEach(p => {
    const div = document.createElement("div");
    div.className = "gallery-item";
    div.innerHTML = `
      <a href="${p.file_url}" 
         data-sub-html="<h4>${p.nama_foto || ''}</h4>
         <p>${p.nama_kategori || ''} - ${p.nama_fotografer || ''} (${p.tanggal || ''})</p>">
        <img src="${p.file_url}" alt="${p.nama_foto || ''}">
      </a>`;
    gallery.appendChild(div);
    newElems.push(div);
  });

  // Layout ulang setelah gambar load
  imagesLoaded(gallery, () => {
    if (!msnry) {
      msnry = new Masonry(gallery, {
        itemSelector: ".gallery-item",
        columnWidth: ".grid-sizer",
        percentPosition: true,
        gutter: 10,
        fitWidth: true
      });
    } else {
  if (newElems.length > 0) {   // ✅ hanya kalau ada gambar baru
    msnry.appended(newElems);
  }
  msnry.reloadItems();
  msnry.layout();
}

    // Reinit LightGallery setiap kali ada gambar baru
    initLightGallery();
  });

  // Kontrol tombol Load More
  const loadMoreBtn = document.getElementById("loadMoreBtn");
  if (photos.length < limit) {
    loadMoreBtn.style.display = "none";
  } else {
    loadMoreBtn.style.display = "inline-block";
  }
}

// Tombol
document.getElementById("loadMoreBtn").addEventListener("click", () => {
  currentPage++;
  loadGallery(lastParams, true);
});

document.getElementById("applyFilter").addEventListener("click", () => {
  currentPage = 1;
  const kategori = document.getElementById("filterKategori").value;
  const fotografer = document.getElementById("filterFotografer").value;
  const cari = document.getElementById("searchInput").value;
  const tanggal = document.getElementById("searchDate").value;
  loadGallery({ kategori, fotografer, cari, tanggal });
});

document.getElementById("refreshBtn").addEventListener("click", () => {
  document.getElementById("filterKategori").value = "";
  document.getElementById("filterFotografer").value = "";
  document.getElementById("searchInput").value = "";
  document.getElementById("searchDate").value = "";
  currentPage = 1;
  loadGallery();
});

document.getElementById("toggleTheme").addEventListener("click", () => {
  document.body.classList.toggle("dark");
});

document.getElementById("backToTop").addEventListener("click", (e) => {
  e.preventDefault();
  window.scrollTo({ top: 0, behavior: "smooth" });
});

// Load awal
loadFilters();
loadGallery();

async function loadFilters() {
  try {
    const kategoriRes = await fetch("api_kategori.php");
    const kategoriData = await kategoriRes.json();
    const kategoriSelect = document.getElementById("filterKategori");
    kategoriSelect.innerHTML = "<option value=''>Semua Kategori</option>";
    kategoriData.forEach(k => {
      kategoriSelect.innerHTML += `<option value="${k.id}">${k.nama_kategori}</option>`;
    });

    const fotograferRes = await fetch("api_fotografer.php");
    const fotograferData = await fotograferRes.json();
    const fotograferSelect = document.getElementById("filterFotografer");
    fotograferSelect.innerHTML = "<option value=''>Semua Fotografer</option>";
    fotograferData.forEach(g => {
      fotograferSelect.innerHTML += `<option value="${g.id}">${g.nama_fotografer}</option>`;
    });
  } catch (err) {
    console.error("Gagal ambil data filter:", err);
  }
}

document.addEventListener("click", (e) => {
  if (e.target.closest(".gallery-item a")) {
    e.preventDefault();
  }
});

lightGallery(document.getElementById("gallery"), {
  selector: ".gallery-item a",
  plugins: [lgZoom, lgThumbnail, lgFullscreen, lgAutoplay,],
  licenseKey: "my-dev-key",
  speed: 500
});

// Sidebar Filter
// Sidebar Filter
const filterSidebar = document.getElementById("filterSidebar");

document.getElementById("openFilter").addEventListener("click", () => {
  filterSidebar.classList.add("open");
});

document.getElementById("closeFilter").addEventListener("click", () => {
  filterSidebar.classList.remove("open");
});

document.getElementById("applyFilter").addEventListener("click", () => {
  filterSidebar.classList.remove("open");
});

document.getElementById("clearFilter").addEventListener("click", () => {
  document.getElementById("filterKategori").value = "";
  document.getElementById("filterFotografer").value = "";
  document.getElementById("searchInput").value = "";
  document.getElementById("searchDate").value = "";
  currentPage = 1;
  loadGallery(); // reload tanpa filter
  filterSidebar.classList.remove("open"); // tutup sidebar
});

const loadMoreWrapper = document.querySelector(".text-center");
if (photos.length < limit) {
  loadMoreBtn.style.display = "none";
  loadMoreWrapper.style.display = "none"; // ✅ hilang total, gak nyisain space
} else {
  loadMoreBtn.style.display = "inline-block";
  loadMoreWrapper.style.display = "block";
}
