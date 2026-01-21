<div class="space-y-6">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">Contact Page Settings</h2>
        <p class="text-muted-foreground mt-1">Configure contact page content, Google Maps, form options, and info cards</p>
    </div>

    @if (session()->has('success'))
        <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Section Text -->
        <x-ui.card title="Section Text" description="Badge, heading, description, and button text for contact section">
            <div class="space-y-6">
                <x-ui.form-field label="Badge Label (Optional)" hint="e.g., Contact Us">
                    <x-ui.input 
                        wire:model="badge_label" 
                        placeholder="e.g., Contact Us" />
                </x-ui.form-field>
                
                <x-ui.form-field 
                    label="Main Heading" 
                    :error="$errors->first('main_heading')">
                    <x-ui.input wire:model="main_heading" />
                </x-ui.form-field>
                
                <x-ui.form-field label="Description">
                    <x-ui.textarea 
                        wire:model="description" 
                        rows="3" />
                </x-ui.form-field>
                
                <x-ui.form-field 
                    label="Submit Button Text" 
                    :error="$errors->first('submit_button_text')">
                    <x-ui.input wire:model="submit_button_text" />
                </x-ui.form-field>
            </div>
        </x-ui.card>

        <!-- Google Map -->
        <x-ui.card title="Google Map" description="Embed code for map display">
            <x-ui.form-field 
                label="Google Map Embed Code (iframe or URL)" 
                hint="Paste the embed code from Google Maps">
                <x-ui.textarea 
                    wire:model="google_map_embed" 
                    rows="4" 
                    placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' 
                    class="font-mono text-sm" />
            </x-ui.form-field>
        </x-ui.card>

        <!-- Form Subject Options -->
        <x-ui.card title="Form Configuration" description="Subject dropdown options for contact form">
            <x-ui.form-field 
                label="Subject Dropdown Options (comma-separated)" 
                hint="Separate options with commas">
                <x-ui.input 
                    wire:model="subject_options" 
                    placeholder="e.g., Nothing,Donation,Volunteer,General Inquiry" />
            </x-ui.form-field>
        </x-ui.card>

        <!-- Card 1: Phone -->
        <x-ui.card title="Card 1: Call Us Today" description="Phone contact card configuration">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <button 
                        type="button" 
                        wire:click="$toggle('card_phone_enabled')" 
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $card_phone_enabled ? 'bg-primary' : 'bg-input' }}">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $card_phone_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                    </button>
                    <label class="text-sm font-medium">Enable Phone Card</label>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.form-field label="Card Title">
                        <x-ui.input wire:model="card_phone_title" />
                    </x-ui.form-field>
                    
                    <x-ui.form-field label="Subtitle (Optional)">
                        <x-ui.input wire:model="card_phone_subtitle" />
                    </x-ui.form-field>
                    
                    <x-ui.form-field label="Phone Number 1">
                        <x-ui.input wire:model="card_phone_1" />
                    </x-ui.form-field>
                    
                    <x-ui.form-field label="Phone Number 2 (Optional)">
                        <x-ui.input wire:model="card_phone_2" />
                    </x-ui.form-field>
                </div>
            </div>
        </x-ui.card>

        <!-- Card 2: Email -->
        <x-ui.card title="Card 2: Mail Information" description="Email contact card configuration">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <button 
                        type="button" 
                        wire:click="$toggle('card_email_enabled')" 
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $card_email_enabled ? 'bg-primary' : 'bg-input' }}">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $card_email_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                    </button>
                    <label class="text-sm font-medium">Enable Email Card</label>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.form-field label="Card Title">
                        <x-ui.input wire:model="card_email_title" />
                    </x-ui.form-field>
                    
                    <x-ui.form-field label="Subtitle (Optional)">
                        <x-ui.input wire:model="card_email_subtitle" />
                    </x-ui.form-field>
                    
                    <x-ui.form-field 
                        label="Email Address 1" 
                        :error="$errors->first('card_email_1')">
                        <x-ui.input 
                            type="email" 
                            wire:model="card_email_1" />
                    </x-ui.form-field>
                    
                    <x-ui.form-field 
                        label="Email Address 2 (Optional)" 
                        :error="$errors->first('card_email_2')">
                        <x-ui.input 
                            type="email" 
                            wire:model="card_email_2" />
                    </x-ui.form-field>
                </div>
            </div>
        </x-ui.card>

        <!-- Card 3: Location -->
        <x-ui.card title="Card 3: Our Location" description="Address card configuration">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <button 
                        type="button" 
                        wire:click="$toggle('card_location_enabled')" 
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $card_location_enabled ? 'bg-primary' : 'bg-input' }}">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-background transition-transform {{ $card_location_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                    </button>
                    <label class="text-sm font-medium">Enable Location Card</label>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.form-field label="Card Title">
                        <x-ui.input wire:model="card_location_title" />
                    </x-ui.form-field>
                    
                    <x-ui.form-field label="Subtitle (Optional)">
                        <x-ui.input wire:model="card_location_subtitle" />
                    </x-ui.form-field>
                    
                    <div class="md:col-span-2">
                        <x-ui.form-field label="Address">
                            <x-ui.textarea 
                                wire:model="card_location_address" 
                                rows="3" />
                        </x-ui.form-field>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <div class="flex gap-3 pt-4 border-t">
            <x-ui.button type="submit">
                Save Changes
            </x-ui.button>
            <x-ui.button 
                variant="outline" 
                :href="'/admin/dashboard'" 
                wire:navigate>
                Cancel
            </x-ui.button>
        </div>
    </form>
</div>
