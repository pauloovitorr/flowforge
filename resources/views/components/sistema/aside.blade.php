<div class="sidebar fixed top-0 left-0 z-40 w-56 h-screen bg-gray-900 border-r border-gray-800 shadow-2xl transition-transform duration-300 ease-in-out">
  <nav aria-label="Navegação Principal" class="h-full px-4 py-6 overflow-y-auto">
    <ul class="space-y-2 font-medium">
      
      {{-- Dashboard --}}
      <li>
        <a href="/dashboard"
          class="flex items-center px-4 py-3 text-base rounded-xl transition-all duration-200 group 
          {{ request()->is('dashboard') ? 'bg-gray-600/30 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-600/20 hover:text-white' }}">
          <i data-lucide="layout-dashboard" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300 {{ request()->is('dashboard') ? 'text-cyan-300' : '' }}"></i>
          Dashboard
        </a>
      </li>

      {{-- Projetos --}}
      <li>
        <a href="{{ route('project.index') }}"
          class="flex items-center px-4 py-3 text-base rounded-xl transition-all duration-200 group 
          {{ request()->routeIs('project.*') ? 'bg-gray-600/30 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-600/20 hover:text-white' }}">
          <i data-lucide="folder" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300 {{ request()->routeIs('project.*') ? 'text-cyan-300' : '' }}"></i>
          Projetos
        </a>
      </li>

      {{-- Workflows --}}
      <li>
        <a href="{{ route('workflow.index') }}"
          class="flex items-center px-4 py-3 text-base rounded-xl transition-all duration-200 group 
          {{ request()->routeIs('workflow.*') ? 'bg-gray-600/30 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-600/20 hover:text-white' }}">
          <i data-lucide="network" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300 {{ request()->routeIs('workflow.*') ? 'text-cyan-300' : '' }}"></i>
          Workflows
        </a>
      </li>

      {{-- Actions --}}
      <li>
        <a href="{{ route('workflow_action.index') }}"
          class="flex items-center px-4 py-3 text-base rounded-xl transition-all duration-200 group 
          {{ request()->routeIs('workflow_action.*') ? 'bg-gray-600/30 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-600/20 hover:text-white' }}">
          <i data-lucide="bolt" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300 {{ request()->routeIs('workflow_action.*') ? 'text-cyan-300' : '' }}"></i>
          Actions
        </a>
      </li>

      {{-- E-mails (Exemplo de subseção ou filtro) --}}
      <li>
        <a href="{{ route('email.index') }}" 
           class="flex items-center px-4 py-3 text-base rounded-xl transition-all duration-200 group 
           {{ request()->routeIs('email.*') ? 'bg-gray-600/30 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-600/20 hover:text-white' }}">
          <i data-lucide="mail" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300 {{ request()->routeIs('email.*') ? 'text-cyan-300' : '' }}"></i>
          <span>E-mails</span>
        </a>
      </li>

      {{-- Configurações --}}
      <li>
        <a href="/configuracoes"
          class="flex items-center px-4 py-3 text-base rounded-xl transition-all duration-200 group 
          {{ request()->is('configuracoes*') ? 'bg-gray-600/30 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-600/20 hover:text-white' }}">
          <i data-lucide="settings" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300 {{ request()->is('configuracoes*') ? 'text-cyan-300' : '' }}"></i>
          Configurações
        </a>
      </li>

    </ul>
  </nav>
</div>