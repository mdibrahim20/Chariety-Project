<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Testimonials</h1>
        <p class="mt-1 text-sm text-gray-600">Manage testimonials section header and individual testimonials</p>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Section Header Form --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Section Header</h2>
                <p class="text-sm text-gray-600 mt-1">Configure the testimonials section header text</p>
            </div>

            {{-- Section Status Toggle --}}
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">Section:</span>
                <button
                    wire:click="$toggle('section_is_active')"
                    type="button"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $section_is_active ? 'bg-indigo-600' : 'bg-gray-200' }}">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $section_is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
                <span class="text-sm font-semibold {{ $section_is_active ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $section_is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <form wire:submit="saveSection" class="space-y-6">
            {{-- Badge Text --}}
            <div>
                <label for="badge_text" class="block text-sm font-medium text-gray-700 mb-2">
                    Badge Text
                    <span class="text-gray-500 font-normal">(e.g., "Testimonial")</span>
                </label>
                <input
                    type="text"
                    id="badge_text"
                    wire:model="badge_text"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Testimonial">
                @error('badge_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Main Heading --}}
            <div>
                <label for="main_heading" class="block text-sm font-medium text-gray-700 mb-2">
                    Main Heading <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="main_heading"
                    wire:model="main_heading"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Stories from the Heart"
                    required>
                @error('main_heading')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sub Heading --}}
            <div>
                <label for="sub_heading" class="block text-sm font-medium text-gray-700 mb-2">
                    Sub Heading / Description
                </label>
                <textarea
                    id="sub_heading"
                    wire:model="sub_heading"
                    rows="3"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Supporting text under the main heading..."></textarea>
                @error('sub_heading')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Save Button --}}
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Header
                </button>
            </div>
        </form>
    </div>

    {{-- Testimonials List --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Testimonials</h2>
                <p class="text-sm text-gray-600 mt-1">Manage individual testimonial items</p>
            </div>
            <button
                wire:click="openCreateModal"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Testimonial
            </button>
        </div>

        @if ($testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($testimonials as $testimonial)
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-5 hover:shadow-md transition-shadow">
                {{-- Header with Avatar and Status --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if ($testimonial->avatar)
                        <img src="{{ Storage::url($testimonial->avatar) }}" alt="{{ $testimonial->reviewer_name }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                        @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($testimonial->reviewer_name, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $testimonial->reviewer_name }}</h3>
                            @if ($testimonial->reviewer_role)
                            <p class="text-xs text-gray-500">{{ $testimonial->reviewer_role }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <button
                        wire:click="toggleStatus({{ $testimonial->id }})"
                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $testimonial->status === 'active' ? 'bg-green-100 text-green-800' : ($testimonial->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($testimonial->status) }}
                    </button>
                </div>

                {{-- Star Rating --}}
                <div class="flex gap-1 mb-3">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        @endfor
                </div>

                {{-- Review Text --}}
                <blockquote class="text-sm text-gray-700 italic mb-4 line-clamp-4">
                    "{{ $testimonial->review_text }}"
                </blockquote>

                {{-- Actions --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <span class="text-xs text-gray-500">Order: #{{ $testimonial->display_order }}</span>
                    <div class="flex gap-2">
                        @if ($testimonial->status === 'pending')
                        <button
                            wire:click="approve({{ $testimonial->id }})"
                            class="text-green-600 hover:text-green-700 text-sm font-medium"
                            title="Approve">
                            Approve
                        </button>
                        @endif
                        <button
                            wire:click="openEditModal({{ $testimonial->id }})"
                            class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                            Edit
                        </button>
                        <button
                            wire:click="delete({{ $testimonial->id }})"
                            wire:confirm="Are you sure you want to delete this testimonial?"
                            class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Empty State --}}
        <div class="text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No testimonials yet</h3>
            <p class="mt-2 text-sm text-gray-500">Get started by adding your first testimonial.</p>
            <div class="mt-6">
                <button
                    wire:click="openCreateModal"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add First Testimonial
                </button>
            </div>
        </div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    @if ($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Background overlay --}}
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 -z-10"></div>

        {{-- Modal panel --}}
        <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-2xl my-8">
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        {{ $editMode ? 'Edit Testimonial' : 'Add New Testimonial' }}
                    </h3>
                    <button
                        wire:click="closeModal"
                        type="button"
                        class="text-white hover:text-gray-200 transition-colors p-1 rounded hover:bg-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <form wire:submit="save">
                <div class="bg-white px-6 py-6 space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                    {{-- Rating --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rating <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2 flex-wrap">
                            @for ($i = 1; $i <= 5; $i++)
                                <button
                                type="button"
                                wire:click="$set('rating', {{ $i }})"
                                class="focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded p-1">
                                <svg class="w-10 h-10 {{ $i <= $rating ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current' }} hover:text-yellow-300 transition-colors" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                </button>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600 self-center">{{ $rating }} star{{ $rating > 1 ? 's' : '' }}</span>
                        </div>
                        @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Review Text --}}
                    <div>
                        <label for="review_text" class="block text-sm font-medium text-gray-700 mb-2">
                            Review / Feedback <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="review_text"
                            wire:model="review_text"
                            rows="4"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Enter the testimonial text..."
                            required></textarea>
                        @error('review_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Reviewer Name --}}
                        <div>
                            <label for="reviewer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Reviewer Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="reviewer_name"
                                wire:model="reviewer_name"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="John Doe"
                                required>
                            @error('reviewer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Reviewer Role --}}
                        <div>
                            <label for="reviewer_role" class="block text-sm font-medium text-gray-700 mb-2">
                                Role / Tag
                            </label>
                            <input
                                type="text"
                                id="reviewer_role"
                                wire:model="reviewer_role"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Volunteer, Donor, etc.">
                            @error('reviewer_role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Avatar Upload --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Avatar (Optional)</label>

                        @if ($avatar)
                        <div class="mb-3">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $avatar->getClientOriginalName() }}</p>
                                    <p class="text-xs text-gray-500">Ready to upload</p>
                                </div>
                                <button
                                    type="button"
                                    wire:click="removeAvatar"
                                    class="text-red-600 hover:text-red-700 text-sm font-medium">
                                    Remove
                                </button>
                            </div>
                        </div>
                        @elseif ($existing_avatar)
                        <div class="mb-3">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                <img src="{{ Storage::url($existing_avatar) }}" alt="Current" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Current Avatar</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <input
                            type="file"
                            wire:model="avatar"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-500">100×100px square | WEBP | Max: 200KB</p>
                        @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="avatar" class="mt-2">
                            <div class="flex items-center gap-2 text-indigo-600">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-sm">Uploading...</span>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="status"
                            wire:model="status"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="active">Active (Show on website)</option>
                            <option value="disabled">Disabled (Hidden)</option>
                            <option value="pending">Pending (Awaiting approval)</option>
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-end gap-3 rounded-b-lg">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">{{ $editMode ? 'Update' : 'Create' }}</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>