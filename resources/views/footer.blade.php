<footer class="bg-gray-800 py-12 text-center text-white">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      
      <div>
        <h2 class="text-lg font-semibold mb-4">Par Mums</h2>
        <p class="text-sm text-gray-400">
          Mēs esam komanda, kas aizrautīgi palīdz sporta klubiem efektīvāk pārvaldīt savu darbību.
        </p>
      </div>
      
      <div>
        <h2 class="text-lg font-semibold mb-4">Saites</h2>
        <ul class="text-sm text-gray-400">
          <li class="mb-2">
            <a href="{{ url('/') }}" class="hover:text-white transition duration-300">Sākums</a>
          </li>
        </ul>
      </div>
      
      <div>
        <h2 class="text-lg font-semibold mb-4">Kontakti</h2>
        <p class="text-sm text-gray-400">
          Rīga, Latvija<br>
          E-pasts: info@teammanager.lv<br>
          Tālrunis: +371 12345678
        </p>
        <div class="flex justify-center mt-4 space-x-4">
          <a href="#" class="text-gray-400 hover:text-white" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-gray-400 hover:text-white" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-gray-400 hover:text-white" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

    </div>
    
    <hr class="my-6 border-gray-600">
    
    <p class="text-center text-sm text-gray-400">
      &copy; {{ date('Y') }} TeamManager. Visas tiesības aizsargātas.
    </p>
  </div>
</footer>