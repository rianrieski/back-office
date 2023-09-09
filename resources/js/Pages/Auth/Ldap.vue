<script setup>

import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    logo:''
})
const form = useForm({
    username:'codingers',
    password:'Bismillah123'
})
const loginLdap = ()=>{
    form.post(route('login.ldap'),{
        onSuccess:(response)=>{
            console.log(response);
    },
    onError:(errors)=>{
        console.log(errors);
    }
    })
}

</script>

<template>
      <html class="h-full bg-white">
      <body class="h-full">
      <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
          <div class="sm:mx-auto sm:w-full sm:max-w-sm">
              <img class="mx-auto h-10 w-auto" :src="logo" alt="Your Company" />
              <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Login LDAP</h2>
          </div>

          <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm" style="margin-top: 10%">
              <form class="space-y-6" @submit.prevent="loginLdap">
                  <div>
                      <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                      <div class="mt-2">
                          <input v-model="form.username" type="text"  required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                      </div>
                  </div>

                  <div>
                      <div class="flex items-center justify-between">
                          <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                      </div>
                      <div class="mt-2">
                          <input v-model="form.password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                      </div>
                  </div>

                  <div>
                      <button type="submit" class="flex w-full justify-center btn btn-primary">Sign in</button>
                  </div>
              </form>
          </div>
      </div>
      </body>
      </html>
</template>

