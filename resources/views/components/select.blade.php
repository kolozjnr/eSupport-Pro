@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}>
    <option value="">-- Select User Type --</option>
    <option value="superadministrator" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
    <option value="qualitycontrol" {{ old('user_type') == 'qualitycontrol' ? 'selected' : '' }}>qualitycontrol</option>
    <option value="supervisor" {{ old('user_type') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
    <option value="account" {{ old('user_type') == 'account' ? 'selected' : '' }}>Account</option>
    <option value="businessmanager" {{ old('user_type') == 'businessmanager' ? 'selected' : '' }}>Businessmanager</option>
    <option value="businesssupervisor" {{ old('user_type') == 'businesssupervisor' ? 'selected' : '' }}>Businesssupervisor</option>
    <option value="developer" {{ old('user_type') == 'developer' ? 'selected' : '' }}>Developer</option>
    <option value="support" {{ old('user_type') == 'support' ? 'selected' : '' }}>Support</option>
    <option value="customer" {{ old('user_type') == 'customer' ? 'selected' : '' }}>Customer</option>
    <option value="businessdeveloper" {{ old('user_type') == 'businessdeveloper' ? 'selected' : '' }}>Business Developer</option>
    <option value="customermanager" {{ old('user_type') == 'customermanager' ? 'selected' : '' }}>Customer manager</option>
    {{-- <option value="moderator" {{ old('user_type') == 'moderator' ? 'selected' : '' }}>Moderator</option>
    <option value="moderator" {{ old('user_type') == 'moderator' ? 'selected' : '' }}>Moderator</option>
    <option value="moderator" {{ old('user_type') == 'moderator' ? 'selected' : '' }}>Moderator</option>
    <option value="moderator" {{ old('user_type') == 'moderator' ? 'selected' : '' }}>Moderator</option> --}}
    <!-- Add more options as needed -->
</select>
