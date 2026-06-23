{
  "project": {
    "name": "Wijaya Transport",
    "type": "Rental Mobil",
    "technology": {
      "backend": "PHP Native",
      "database": "MySQL",
      "frontend": "HTML5, CSS3, JavaScript, Bootstrap 5",
      "payment_gateway": "Midtrans"
    }
  },
  "modules": {
    "authentication": {
      "description": "Sistem login dan registrasi",
      "features": [
        "Login Admin",
        "Login User",
        "Register User",
        "Forgot Password",
        "Logout",
        "Session Management"
      ]
    },
    "admin_panel": {
      "description": "Panel pengelolaan sistem",
      "pages": [
        {
          "name": "Dashboard",
          "features": [
            "Statistik Rental",
            "Jumlah Mobil",
            "Jumlah User",
            "Total Pendapatan",
            "Transaksi Terbaru"
          ]
        },
        {
          "name": "Manajemen Mobil",
          "features": [
            "Tambah Mobil",
            "Edit Mobil",
            "Hapus Mobil",
            "Upload Foto Mobil",
            "Status Ketersediaan"
          ]
        },
        {
          "name": "Manajemen User",
          "features": [
            "Daftar User",
            "Detail User",
            "Blokir User",
            "Reset Password"
          ]
        },
        {
          "name": "Manajemen Rental",
          "features": [
            "Daftar Booking",
            "Verifikasi Booking",
            "Status Pengembalian",
            "Riwayat Rental"
          ]
        },
        {
          "name": "Pembayaran",
          "features": [
            "Monitoring Pembayaran",
            "Verifikasi Transaksi",
            "Laporan Pendapatan"
          ]
        },
        {
          "name": "Laporan",
          "features": [
            "Laporan Rental",
            "Laporan Mobil",
            "Laporan Pendapatan",
            "Export PDF",
            "Export Excel"
          ]
        }
      ]
    },
    "user_panel": {
      "description": "Panel pelanggan",
      "pages": [
        {
          "name": "Beranda",
          "features": [
            "Banner Promosi",
            "Daftar Mobil Tersedia",
            "Pencarian Mobil"
          ]
        },
        {
          "name": "Detail Mobil",
          "features": [
            "Foto Mobil",
            "Spesifikasi",
            "Harga Sewa",
            "Status Ketersediaan"
          ]
        },
        {
          "name": "Booking Mobil",
          "features": [
            "Pilih Tanggal",
            "Pilih Durasi",
            "Upload KTP",
            "Konfirmasi Booking"
          ]
        },
        {
          "name": "Riwayat Rental",
          "features": [
            "Daftar Rental",
            "Status Rental",
            "Invoice"
          ]
        },
        {
          "name": "Profil",
          "features": [
            "Edit Profil",
            "Ubah Password"
          ]
        }
      ]
    },
    "payment_gateway": {
      "provider": "Midtrans",
      "features": [
        "Snap Payment",
        "Transfer Bank",
        "QRIS",
        "E-Wallet",
        "Virtual Account",
        "Webhook Notification",
        "Auto Update Status Pembayaran"
      ]
    }
  },
  "database": {
    "tables": [
      {
        "name": "users",
        "fields": [
          "id",
          "name",
          "email",
          "password",
          "phone",
          "address",
          "role",
          "created_at"
        ]
      },
      {
        "name": "cars",
        "fields": [
          "id",
          "brand",
          "model",
          "year",
          "plate_number",
          "price_per_day",
          "image",
          "status",
          "created_at"
        ]
      },
      {
        "name": "bookings",
        "fields": [
          "id",
          "user_id",
          "car_id",
          "start_date",
          "end_date",
          "total_price",
          "status",
          "created_at"
        ]
      },
      {
        "name": "payments",
        "fields": [
          "id",
          "booking_id",
          "transaction_id",
          "payment_method",
          "amount",
          "status",
          "payment_date"
        ]
      },
      {
        "name": "car_images",
        "fields": [
          "id",
          "car_id",
          "image_path"
        ]
      }
    ]
  },
  "folder_structure": {
    "root": [
      "/assets",
      "/config",
      "/controllers",
      "/models",
      "/views",
      "/uploads",
      "/middleware",
      "/helpers",
      "/vendor"
    ],
    "views": [
      "/views/auth",
      "/views/admin",
      "/views/user",
      "/views/layouts"
    ]
  },
  "development_phases": [
    {
      "phase": 1,
      "name": "Setup Project",
      "tasks": [
        "Konfigurasi PHP Native",
        "Setup Database MySQL",
        "Struktur Folder"
      ]
    },
    {
      "phase": 2,
      "name": "Authentication",
      "tasks": [
        "Login",
        "Register",
        "Session Management"
      ]
    },
    {
      "phase": 3,
      "name": "Admin Module",
      "tasks": [
        "Dashboard",
        "CRUD Mobil",
        "CRUD User",
        "Laporan"
      ]
    },
    {
      "phase": 4,
      "name": "User Module",
      "tasks": [
        "Booking Mobil",
        "Riwayat Rental",
        "Profil User"
      ]
    },
    {
      "phase": 5,
      "name": "Payment Gateway",
      "tasks": [
        "Integrasi Midtrans",
        "Webhook",
        "Invoice"
      ]
    },
    {
      "phase": 6,
      "name": "Testing & Deployment",
      "tasks": [
        "Unit Testing",
        "UAT",
        "Deploy ke Hosting"
      ]
    }
  ],
  "ui_design": {
    "theme": "Modern Transportation",
    "primary_color": "#0D6EFD",
    "secondary_color": "#212529",
    "responsive": true,
    "layout_reference": "Mengikuti desain.md"
  }
}