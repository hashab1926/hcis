// rules
const rules = $("#karyawan-store").validate({
  rules: {
    nip: { required: true },
    nama_karyawan: {
      required: true,
      maxlength: 100,
    },
    id_pangkat: { required: true },
    id_jabatan: { required: true },
    id_divisi: { required: true },
    email: {
      required: true,
      email: true,
    },
  },

  messages: {
    nip: { required: "nip harus diisi" },
    nama_karyawan: {
      required: "nama lengkap harus diisi",
      maxlength: "nama lengkap maksimal 100 karakter",
    },
    id_pangkat: { required: "pangkat harus diisi" },
    id_jabatan: { required: "jabatan harus diisi" },
    id_divisi: { required: "divisi harus diisi" },
    email: {
      required: "email harus diisi",
      email: "email tidak valid",
    },
  },
});

$("#karyawan-store").submit(function (evt) {
  evt.preventDefault();

  if (rules.valid() == false) return false;

  const data = new FormData(this);
  data.append(getCsrfName(), getCsrfHash());

  $.ajax({
    type: "POST",
    data: data,
    processData: false,
    contentType: false,
    url: `${baseUrl}/karyawan/store`,
    dataType: "json",
    beforeSend: function () {
      enableLoading("tambah");
    },
  }).done(function (response) {
    resetCsrfToken(response.token);
    disableLoading("tambah", buttonHtml);

    if (response.status_code != 201) {
      warningMessage("Pesan", response.message);
      return false;
    }

    successMessage("Pesan", response.message);
  });
});
