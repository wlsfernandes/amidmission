<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Features
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Feature Type</label>

            <select name="feature_type" class="form-control" required>
                <option value="">Select Feature</option>

                <option value="team"
                    {{ old('feature_type', $section->feature_type ?? '') == 'team' ? 'selected' : '' }}>Team Carousel
                </option>

                <option value="partners"
                    {{ old('feature_type', $section->feature_type ?? '') == 'partners' ? 'selected' : '' }}>Partners
                </option>

                <option value="testimonial"
                    {{ old('feature_type', $section->feature_type ?? '') == 'testimonial' ? 'selected' : '' }}>
                    Testimonial</option>

                <option value="services"
                    {{ old('feature_type', $section->feature_type ?? '') == 'services' ? 'selected' : '' }}>Services
                    Carousel</option>

                <option value="blog"
                    {{ old('feature_type', $section->feature_type ?? '') == 'blog' ? 'selected' : '' }}>Blog Carousel
                </option>

                <option value="donate"
                    {{ old('feature_type', $section->feature_type ?? '') == 'donate' ? 'selected' : '' }}>Donate
                    Carousel</option>

                <option value="event"
                    {{ old('feature_type', $section->feature_type ?? '') == 'event' ? 'selected' : '' }}>Event Carousel
                </option>
                <option value="contact"
                    {{ old('feature_type', $section->feature_type ?? '') == 'contact' ? 'selected' : '' }}>Contact
                    Section</option>

            </select>
        </div>
        <p class="text-muted">
            A <strong>Feature</strong> section displays dynamic content from your platform in a visually engaging way,
            such as carousels or highlighted blocks. For example, you can showcase recent blog posts, team members,
            testimonials, services, events, or contact information. Instead of adding content manually, this section
            automatically pulls and
            displays the latest items, keeping your page fresh and interactive.
        </p>
    </div>
</div>
