<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
  <span class="sr-only">Open sidebar</span>
  <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
  </svg>
</button>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
  <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 border-r border-gray-200">
    <ul class="space-y-2 font-medium">
     <li>
       <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-auto h-auto">
     </li>

     @php
       function activeClass($routes) {
           return request()->routeIs($routes) ? 'text-white bg-[#7d5f12]' : 'text-gray-900 hover:bg-gray-200';
       }

       function iconColorClass($routes) {
           return request()->routeIs($routes) ? 'text-white' : 'text-gray-400 group-hover:text-[#7d5f12]';
       }
       @endphp

     <li>
       <a href="{{ route('assignments.index') }}"
       class="flex items-center p-2 rounded-lg group {{ activeClass(['assignments.index', 'assignments.*']) }}">

       <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['assignments.index', 'assignments.*']) }}"
           xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
           <path fill-rule="evenodd" d="M4.857 3A1.857 1.857 0 0 0 3 4.857v4.286C3 10.169 3.831 11 4.857 11h4.286A1.857 1.857 0 0 0 11 9.143V4.857A1.857 1.857 0 0 0 9.143 3H4.857Zm10 0A1.857 1.857 0 0 0 13 4.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 21 9.143V4.857A1.857 1.857 0 0 0 19.143 3h-4.286Zm-10 10A1.857 1.857 0 0 0 3 14.857v4.286C3 20.169 3.831 21 4.857 21h4.286A1.857 1.857 0 0 0 11 19.143v-4.286A1.857 1.857 0 0 0 9.143 13H4.857ZM18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd"/>
       </svg>
         <span class="ms-3">Assignment</span>
       </a>
     </li>
     

     <li>
       <a href="{{ route('rooms.index') }}" 
          class="flex items-center p-2 rounded-lg group {{ activeClass(['rooms.index', 'rooms.*']) }}">
          
         <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['rooms.index', 'rooms.*']) }}" 
              aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
              width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
           <path d="M14 19V5h4a1 1 0 0 1 1 1v11h1a1 1 0 0 1 0 2h-6Z"/>
           <path fill-rule="evenodd" d="M12 4.571a1 1 0 0 0-1.275-.961l-5 1.428A1 1 0 0 0 5 6v11H4a1 1 0 0 0 0 2h1.86l4.865 1.39A1 1 0 0 0 12 19.43V4.57ZM10 11a1 1 0 0 1 1 1v.5a1 1 0 0 1-2 0V12a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
         </svg>
     
         <span class="flex-1 ms-3 whitespace-nowrap">Rooms</span>
       </a>
     </li>

     <li>
       <a href="{{ route('therapists.index') }}" 
          class="flex items-center p-2 rounded-lg group {{ activeClass(['therapists.index', 'therapists.*']) }}">
         <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['therapists.index', 'therapists.*']) }}" 
              aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
              width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
         </svg>
         <span class="flex-1 ms-3 whitespace-nowrap">Therapist</span>
       </a>
     </li>

     <li>
       <a href="{{ route('guests.index') }}" 
          class="flex items-center p-2 rounded-lg group {{ activeClass(['guests.index', 'guests.*']) }}">
         <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['guests.index', 'guests.*']) }}" 
              aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
              width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm1.942 4a3 3 0 0 0-2.847 2.051l-.044.133-.004.012c-.042.126-.055.167-.042.195.006.013.02.023.038.039.032.025.08.064.146.155A1 1 0 0 0 6 17h6a1 1 0 0 0 .811-.415.713.713 0 0 1 .146-.155c.019-.016.031-.026.038-.04.014-.027 0-.068-.042-.194l-.004-.012-.044-.133A3 3 0 0 0 10.059 14H7.942Z" clip-rule="evenodd"/>
         </svg>
         <span class="flex-1 ms-3 whitespace-nowrap">Guest</span>
       </a>
     </li>

     <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-300">
     <li>
         <a href="{{ route('treatments.index') }}" 
            class="flex items-center p-2 rounded-lg group {{ activeClass(['treatments.index', 'treatments.*']) }}">
           <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['treatments.index', 'treatments.*']) }}" 
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd"/>
           </svg>
           <span class="flex-1 ms-3 whitespace-nowrap">Spa Treatment</span>
         </a>
     </li>
     <li>
         <a href="{{ route('categories.index') }}" 
         class="flex items-center p-2 rounded-lg group {{ activeClass(['categories.index', 'categories.*']) }}" >
           <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['categories.index', 'categories.*']) }}" 
           aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
           width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
           <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
           </svg>
           <span class="flex-1 ms-3 whitespace-nowrap">Product Category</span>
         </a>
       
       </a>
     </li>
     <li>
         <a href="{{ route('products.index') }}" 
         class="flex items-center p-2 rounded-lg group {{ activeClass(['products.index', 'products.*']) }}">
         <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['products.index', 'products.*']) }}" 
         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
         width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
         <path fill="currentColor" d="M12 11c-.2299 0-.4004.0774-.4693.1116-.0839.0417-.1491.0873-.1903.1184-.083.0626-.1535.1309-.2048.1837-.1071.1103-.2209.2476-.3317.3923-.2255.2944-.4919.6891-.7477 1.1281-.2554.4383-.51194.9409-.70723 1.4498-.19007.4953-.34899 1.0647-.34899 1.6161 0 1.6569 1.34312 3 3.00002 3 1.6568 0 3-1.3431 3-3 0-.5514-.1589-1.1208-.349-1.6161-.1953-.5089-.4518-1.0115-.7073-1.4498-.2557-.439-.5222-.8337-.7476-1.1281-.1109-.1447-.2246-.282-.3317-.3923-.0513-.0528-.1218-.1211-.2049-.1837-.0411-.0311-.1063-.0767-.1903-.1184C12.4003 11.0774 12.2299 11 12 11Z"/>
         <path fill="currentColor" fill-rule="evenodd" d="M8.99998 2c-.55228 0-1 .44772-1 1v3c0 .55228.44772 1 1 1v1.09419c-.05797.03621-.12962.07946-.21086.12849-.24044.14511-.56485.34091-.86716.55505C7.10458 9.35671 5.99998 10.3674 5.99998 12v7l-.00021.0705c-.00185.4157-.00535 1.2054.44872 1.8544C6.99323 21.7034 7.94156 22 9.14284 22h5.71426c1.2013 0 2.1496-.2966 2.6944-1.0751.454-.649.4505-1.4387.4487-1.8544L18 19v-7c0-1.6326-1.1046-2.64329-1.922-3.22227-.3023-.21414-.6267-.40994-.8672-.55505-.0811-.04899-.1529-.0923-.2108-.12849V7c.5523 0 1-.44772 1-1V3c0-.55228-.4477-1-1-1H8.99998ZM11 8.5V7h2v1.5c0 .53707.3707.86588.4654.94981.1501.13316.3302.25013.4733.33959.1031.06443.2035.12498.3032.18511.2226.13429.4419.26659.6801.43529C15.6046 10.8933 16 11.3826 16 12v7c0 .2478-.0018.4169-.0232.5648-.02.1381-.0499.1934-.0644.214-.007.0101-.0384.0552-.171.1055-.1513.0574-.423.1157-.8843.1157H9.14284c-.46132 0-.73297-.0583-.8843-.1157-.13261-.0503-.16434-.0959-.17136-.106-.01448-.0207-.04404-.0754-.06402-.2135-.0214-.1479-.02318-.317-.02318-.5648v-7c0-.6174.3954-1.1067 1.07802-1.5902.23818-.1687.45741-.301.68008-.43529.09969-.06013.20008-.12068.30312-.18511.1432-.08946.3237-.20679.4738-.33996.0947-.08392.465-.41237.465-.94944Z" clip-rule="evenodd"/>
         </svg>
         <span class="flex-1 ms-3 whitespace-nowrap">Spa Products</span>
       </a>
     </li>
     <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-300">

     

     

     <li>
       <a href="{{ route('profile.edit') }}" 
          class="flex items-center p-2 rounded-lg group {{ activeClass(['profile.index', 'profile.*']) }}">
         <svg class="w-6 h-6 transition duration-75 {{ iconColorClass(['profile.index', 'profile.*']) }}" 
              aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
              width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
         </svg>
         <span class="flex-1 ms-3 whitespace-nowrap">Profile</span>
       </a>
     </li>
     <li>
       <a href="{{ route('backup.index') }}" 
          class="flex items-center p-2 rounded-lg group {{ activeClass(['backup.index']) }}">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 w-6 h-6 transition duration-75 {{ iconColorClass(['backup.index']) }}">
           <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
         </svg>
         <span class="flex-1 ms-3 whitespace-nowrap">Backup Data</span>
       </a>
     </li>

     <li>
       <form method="POST" action="{{ route('logout') }}" class="w-full">
           @csrf
           <button type="submit" 
               class="w-full text-left flex items-center p-2 rounded-lg group text-gray-900 hover:bg-gray-200 "
               >
               <svg class="w-6 h-6 text-gray-400 group-hover:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
           </button>
       </form>
     </li>

     
      
    </ul>
  </div>
</aside> 