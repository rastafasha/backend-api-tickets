<?php

namespace App\Fakers;

use Faker\Provider\Base;

class EventFakerProvider extends Base
{
    /**
     * Array of event types with their Spanish names
     */
    protected $eventTypes = [
        'Promoción de Lanzamiento',
        'Conferencia de Tecnología',
        'Seminario de Innovación',
        'Workshop de Desarrollo',
        'Festival de Arte',
        'Concierto de Música',
        'Exposición de Fotografía',
        'Taller de Cocina',
        'Encuentro de Negocios',
        'Convención de Salud',
        'Feria de Libros',
        'Campaña de Conciencia',
        'Evento de Networking',
        'Simposio Científico',
        'Masterclass de Liderazgo',
        'Encuentro de Startups',
        'Conferencia de Marketing',
        'Seminario de Finanzas',
        'Expo de Diseño',
        'Foro de Educación'
    ];

    /**
     * Array of descriptive words for events
     */
    protected $descriptors = [
        'Internacional',
        'Nacional',
        'Regional',
        'Anual',
        'Especial',
        'Premium',
        'Exclusivo',
        'Innovador',
        'Sostenible',
        'Digital',
        'Presencial',
        'Híbrido',
        'Virtual',
        'Interactivo',
        'Profesional',
        'Académico',
        'Comercial',
        'Cultural',
        'Deportivo',
        'Técnico'
    ];

    /**
     * Array of specific event contexts
     */
    protected $contexts = [
        '2025',
        'Nueva Generación',
        'XXI Siglo',
        'Moderno',
        'Futuro',
        'Innovación',
        'Transformación Digital',
        'Sustentabilidad',
        'Tecnología Avanzada',
        'Bienestar',
        'Emprendimiento',
        'Excelencia',
        'Calidad',
        'Creatividad',
        'Eficiencia'
    ];

    /**
     * Generate a random event name
     * 
     * @return string
     */
    public function evento()
    {
        // Randomly choose between different patterns
        $pattern = rand(1, 4);

        switch ($pattern) {
            case 1:
                // Pattern: "Event Type"
                return $this->generator->randomElement($this->eventTypes);
                
            case 2:
                // Pattern: "Event Type + Context"
                $eventType = $this->generator->randomElement($this->eventTypes);
                $context = $this->generator->randomElement($this->contexts);
                return $eventType . ' ' . $context;
                
            case 3:
                // Pattern: "Descriptor + Event Type"
                $descriptor = $this->generator->randomElement($this->descriptors);
                $eventType = $this->generator->randomElement($this->eventTypes);
                return $descriptor . ' ' . $eventType;
                
            case 4:
                // Pattern: "Event Type + Year"
                $eventType = $this->generator->randomElement($this->eventTypes);
                $year = $this->generator->randomElement(['2025', '2026', 'Jubilario', 'Anual']);
                return $eventType . ' ' . $year;
                
            default:
                return $this->generator->randomElement($this->eventTypes);
        }
    }

    /**
     * Generate a shorter event name
     * 
     * @return string
     */
    public function eventoCorto()
    {
        $shortEvents = [
            'Tech Summit',
            'Design Week',
            'Code Fest',
            'Startup Pitch',
            'Innovation Day',
            'Dev Conference',
            'Marketing Pro',
            'Business Forum',
            'Creative Lab',
            'Future Tech',
            'AI Summit',
            'Data Science',
            'Cloud Expo',
            'Mobile World',
            'Security Pro'
        ];

        return $this->generator->randomElement($shortEvents);
    }

    /**
     * Generate a promotional event name
     * 
     * @return string
     */
    public function promocion()
    {
        $promotions = [
            'Promoción de Lanzamiento',
            'Mega Oferta',
            'Descuento Especial',
            'Campaña Premium',
            'Promoción Exclusiva',
            'Oferta de Bienvenida',
            'Promoción Relámpago',
            'Liquidación Total',
            'Promoción VIP',
            'Oferta por Tiempo Limitado',
            'Promoción Estelar',
            'Mega Promoción',
            'Promoción Golden',
            'Black Friday',
            'Cyber Monday'
        ];

        return $this->generator->randomElement($promotions);
    }
}
