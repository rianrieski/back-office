
<template>
    <div>
      <form @submit.prevent="handleSubmit">
        <input v-model="formData.name" type="text" placeholder="Name">
        <button type="submit">Submit</button>
      </form>
    </div>
  </template>

<script>
  export default {
    data() {
      return {
        formData: {
          name: '',
        },
      };
    },
    methods: {
      async handleSubmit() {
        const result = await Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, submit it!',
          cancelButtonText: 'No, cancel!',
        });

        if (result.isConfirmed) {
          // Lanjutkan dengan mengirimkan form
          // Misalnya, panggil method untuk mengirim form ke server
          this.sendForm();
        }
      },
      sendForm() {
        // Simulasi pengiriman form ke server
        // Di sini Anda dapat menggunakan Axios atau method lainnya untuk mengirim data ke server
        console.log('Form submitted:', this.formData);
      },
    },
  };
  </script>
