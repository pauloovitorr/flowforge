<div
  class="sidebar fixed top-0 left-0 z-40 w-56 h-screen bg-gray-900 border-r  shadow-2xl transition-transform duration-300 ease-in-out">
  <nav aria-label="Navegação Principal" class="h-full px-4 py-6 overflow-y-auto">
    <ul class="space-y-2 font-medium text-gray-300">
      <li>
        <a href="/dashboard"
          class="flex items-center px-4 py-3 text-base rounded-xl hover:bg-gray-600/20 hover:text-white hover:shadow-lg transition-all duration-200 group">
          <i data-lucide="layout-dashboard" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300"></i>
          Dashboard
        </a>
      </li>
      <li>
        <a href="{{ route('project.index') }}"
          class="flex items-center px-4 py-3 text-base rounded-xl hover:bg-gray-600/20 hover:text-white hover:shadow-lg transition-all duration-200 group">
          <i data-lucide="folder" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300"></i>
          Projetos
        </a>
      </li>

      <li>
        <a href="{{ route('workflow.index') }}"
          class="flex items-center px-4 py-3 text-base rounded-xl hover:bg-gray-600/20 hover:text-white hover:shadow-lg transition-all duration-200 group">
          <i data-lucide="network" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300"></i>
          Workflows
        </a>
      </li>

      <li>
        <a href="{{ route('workflow_action.index') }}"
          class="flex items-center px-4 py-3 text-base rounded-xl hover:bg-gray-600/20 hover:text-white hover:shadow-lg transition-all duration-200 group">
          <i data-lucide="network" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300"></i>
          Actions
        </a>
      </li>

      <li>
        <a href="/configuracoes"
          class="flex items-center px-4 py-3 text-base rounded-xl hover:bg-gray-600/20 hover:text-white hover:shadow-lg transition-all duration-200 group">
          <i data-lucide="settings" class="w-6 h-6 mr-4 transition-colors group-hover:text-cyan-300"></i>
          Configurações
        </a>
      </li>
    </ul>
  </nav>
</div>