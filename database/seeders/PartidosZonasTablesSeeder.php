<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PartidosZonasTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('partidos')->insert([
        	['partido' => 'Vicente López'],//1
        	['partido' => 'San Isidro'],//2
        	['partido' => 'San Fernando'],//3
        	['partido' => 'Tigre'],//4
        	['partido' => 'General San Martín'],//5
        	['partido' => 'Malvinas Argentina'],//6
        	['partido' => 'José C. Paz'],//7
        	['partido' => 'San Miguel'],//8
        	['partido' => 'Tres de Febrero'],//9
        	['partido' => 'Morón'],//10
        	['partido' => 'Hurligham'],//11
        	['partido' => 'Ituzaingó'],//12
        	['partido' => 'Moreno'],//13
        	['partido' => 'Merlo'],//14
            ['partido' => 'La Matanza'],// 15
        	['partido' => 'Avellaneda'],//16
        	['partido' => 'Lanús'],//1
        	['partido' => 'Lomas d Zamora'],//18
        	['partido' => 'Quilmes'],//19
        	['partido' => 'Almirante Brown'],//20
        	['partido' => 'Esteban Echeverría'],//21
        	['partido' => 'Ezeiza'],//22
        	['partido' => 'Berazategui'],//23
        	['partido' => 'Florencio Varela'],//24
        	['partido' => 'Buenos Aires'],//25
        	['partido' => 'Cañuelas'],//26
        	['partido' => 'Ensenada'],//27
        	['partido' => 'Berisso'],//28
        	['partido' => 'Campana'],//29
        	['partido' => 'Cnel. Brandsen'],//30
        	['partido' => 'Ex. de la Cruz'],//31
        	['partido' => 'Gral. Las Heras'],//32
        	['partido' => 'Luján'],//33
        	['partido' => 'Marcos Paz'],//34
        	['partido' => 'Presidente Perón'],//35
        	['partido' => 'San Vicente'],//36
        	['partido' => 'Zárate'],//37
        	['partido' => 'La Plata']//38
        ]
        );
        //registrando zonas
        \DB::table('zonas')->insert([
        	['zona' => 'Vicente López', 'id_partido' => 1],//1
        	['zona' => 'Florida', 'id_partido' => 1],//2
        	['zona' => 'Villa Martelli', 'id_partido' => 1],//3
        	['zona' => 'Florida Oeste', 'id_partido' => 1],//4
        	['zona' => 'Olivos', 'id_partido' => 1],//5
        	['zona' => 'La Lucila', 'id_partido' => 1],//
        	['zona' => 'Munro', 'id_partido' => 1],
        	['zona' => 'Carapachay', 'id_partido' => 1],
        	['zona' => 'Villa Adelina', 'id_partido' => 1],


        	['zona' => 'San Isidro', 'id_partido' => 2],
        	['zona' => 'Martínez', 'id_partido' => 2],
        	['zona' => 'Villa Adelina', 'id_partido' => 2],
        	['zona' => 'Boulogne', 'id_partido' => 2],
        	['zona' => 'Acassuso', 'id_partido' => 2],
        	['zona' => 'Beccar', 'id_partido' => 2],


        	['zona' => 'San Fernando', 'id_partido' => 3],
        	['zona' => 'Victoria', 'id_partido' => 3],
        	['zona' => 'Virreyes', 'id_partido' => 3],

        	['zona' => 'Tigre', 'id_partido' => 4],
        	['zona' => 'Tronco del Talar', 'id_partido' => 4],
        	['zona' => 'General Pacheco', 'id_partido' => 4],
        	['zona' => 'Ricardo Rojas', 'id_partido' => 4],
        	['zona' => 'El Talar', 'id_partido' => 4],
        	['zona' => 'Don Torcuato', 'id_partido' => 4],
        	['zona' => 'Rincón de Milberg', 'id_partido' => 4],
        	['zona' => 'Benavídez', 'id_partido' => 4],
        	['zona' => 'Dique Lujan', 'id_partido' => 4],
        	['zona' => 'Zona de Reserva', 'id_partido' => 4],

        	['zona' => 'San Martín', 'id_partido' => 5],
        	['zona' => 'Villa Maipú', 'id_partido' => 5],
        	['zona' => 'Villa Lynch', 'id_partido' => 5],
        	['zona' => 'San Andrés', 'id_partido' => 5],
        	['zona' => 'Villa Ballester', 'id_partido' => 5],
        	['zona' => 'Billinghurst', 'id_partido' => 5],
        	['zona' => 'José León Suárez', 'id_partido' => 5],
        	['zona' => 'Loma Hermosa', 'id_partido' => 5],

        	['zona' => 'Área de Promoción El Triángulo', 'id_partido' => 6],
        	['zona' => 'Tortuguitas', 'id_partido' => 6],
        	['zona' => 'Grand Bourg', 'id_partido' => 6],
        	['zona' => 'Pablo Nogués', 'id_partido' => 6],
        	['zona' => 'Los Polvorines', 'id_partido' => 6],
        	['zona' => 'Villa de Mayo', 'id_partido' => 6],
        	['zona' => 'Ingeniero Adolfo Sourdeaux', 'id_partido' => 6],


        	['zona' => 'José C. Paz', 'id_partido' => 7],
        	['zona' => 'Del Viso', 'id_partido' => 7],
        	['zona' => 'Toruguitas', 'id_partido' => 7],


        	['zona' => 'San Miguel', 'id_partido' => 8],
        	['zona' => 'Muñiz', 'id_partido' => 8],
        	['zona' => 'Bella Vista', 'id_partido' => 8],
        	['zona' => 'Campo de Mayo', 'id_partido' => 8],

        	['zona' => 'Sáenz Peña', 'id_partido' => 9],
        	['zona' => 'Villa Raffo', 'id_partido' => 9],
        	['zona' => 'José Ingenieros', 'id_partido' => 9],
        	['zona' => 'Ciudadela', 'id_partido' => 9],
        	['zona' => 'Santos Lugares', 'id_partido' => 9],
        	['zona' => 'Caseros', 'id_partido' => 9],
        	['zona' => 'Villa Bosch', 'id_partido' => 9],
        	['zona' => 'Martín Coronado', 'id_partido' => 9],
        	['zona' => 'Ciudad Lomas Jardín del Palomar', 'id_partido' => 9],
        	['zona' => 'Loma Hermosa', 'id_partido' => 9],
        	['zona' => 'Pablo Podestá', 'id_partido' => 9],
        	['zona' => 'El Libertador', 'id_partido' => 9],
        	['zona' => 'Churruca', 'id_partido' => 9],
        	['zona' => 'Once', 'id_partido' => 9],
        	['zona' => 'Remedios de Escalada', 'id_partido' => 9],

        	['zona' => 'Morón', 'id_partido' => 10],
        	['zona' => 'Villa Sarmiento', 'id_partido' => 10],
        	['zona' => 'El Palomar', 'id_partido' => 10],
        	['zona' => 'Haedo', 'id_partido' => 10],
        	['zona' => 'Castelar', 'id_partido' => 10],

        	['zona' => 'Hurligham', 'id_partido' => 11],
        	['zona' => 'William C. Morris', 'id_partido' => 11],
        	['zona' => 'Villa Tesei', 'id_partido' => 11],

        	['zona' => 'Ituzaingó', 'id_partido' => 12],
        	['zona' => 'Udaondo', 'id_partido' => 12],

        	['zona' => 'Moreno', 'id_partido' => 13],
        	['zona' => 'Trujui', 'id_partido' => 13],
        	['zona' => 'Paso del Rey', 'id_partido' => 13],
        	['zona' => 'La Reja', 'id_partido' => 13],
        	['zona' => 'Francisco Álvarez', 'id_partido' => 13],
        	['zona' => 'Cuartel V', 'id_partido' => 13],

        	['zona' => 'Merlo', 'id_partido' => 14],
        	['zona' => 'San Antonio de Padua', 'id_partido' => 14],
        	['zona' => 'Libertad', 'id_partido' => 14],
        	['zona' => 'Parque San Martín', 'id_partido' => 14],
        	['zona' => 'Mariano Acosta', 'id_partido' => 14],
        	['zona' => 'Ponte Vedra', 'id_partido' => 14],

        	['zona' => 'Ramos Mejía', 'id_partido' => 15],
        	['zona' => 'Lomas del Mirador', 'id_partido' => 15],
        	['zona' => 'La Tablada', 'id_partido' => 15],
        	['zona' => 'Villa Madero', 'id_partido' => 15],
        	['zona' => 'Villa Celina', 'id_partido' => 15],
        	['zona' => 'Tapiales', 'id_partido' => 15],
        	['zona' => 'Aldo Bonzi', 'id_partido' => 15],
        	['zona' => 'San Justo', 'id_partido' => 15],
        	['zona' => 'Villa Luzuriaga', 'id_partido' => 15],
        	['zona' => 'Isidro Casanova', 'id_partido' => 15],
        	['zona' => 'Ciudad Evita', 'id_partido' => 15],
        	['zona' => 'Gregorio de Laferrere', 'id_partido' => 15],
        	['zona' => 'Rafael Castillo', 'id_partido' => 15],
        	['zona' => 'González Catán', 'id_partido' => 15],
        	['zona' => 'Virrey de Pino', 'id_partido' => 15],
        	['zona' => '20 de Junio', 'id_partido' => 15],

        	['zona' => 'Avellaneda', 'id_partido' => 16],
        	['zona' => 'Dock Sud', 'id_partido' => 16],
        	['zona' => 'Piñeyro', 'id_partido' => 16],
        	['zona' => 'Gerli', 'id_partido' => 16],
        	['zona' => 'Crucecita', 'id_partido' => 16],
        	['zona' => 'Sarandi', 'id_partido' => 16],
        	['zona' => 'Zona de Reserva', 'id_partido' => 16],
        	['zona' => 'Villa Domínico', 'id_partido' => 16],
        	['zona' => 'Wilde', 'id_partido' => 16],

        	['zona' => 'Lanús', 'id_partido' => 17],
        	['zona' => 'Valentín Alsina', 'id_partido' => 17],
        	['zona' => 'Gerli', 'id_partido' => 17],
        	['zona' => 'Lanús de Oeste', 'id_partido' => 17],
        	['zona' => 'Remedios de Escalada', 'id_partido' => 17],
        	['zona' => 'Monte Chingolo', 'id_partido' => 17],

        	['zona' => 'Lomas de Zamora', 'id_partido' => 18],
        	['zona' => 'Villa Fiorito', 'id_partido' => 18],
        	['zona' => 'Ingeniero Budge', 'id_partido' => 18],
        	['zona' => 'Villa Centenario', 'id_partido' => 18],
        	['zona' => 'Banfield', 'id_partido' => 18],
        	['zona' => 'Temperley', 'id_partido' => 18],
        	['zona' => 'Turdera', 'id_partido' => 18],
        	['zona' => 'Llavallol', 'id_partido' => 18],

        	['zona' => 'Quilmes', 'id_partido' => 19],
        	['zona' => 'Don Bosco', 'id_partido' => 19],
        	['zona' => 'Bernal Oeste', 'id_partido' => 19],
        	['zona' => 'Bernal', 'id_partido' => 19],
        	['zona' => 'Quilmes Oeste', 'id_partido' => 19],
        	['zona' => 'Ezpeleta', 'id_partido' => 19],
        	['zona' => 'Ezpeleta Oeste', 'id_partido' => 19],
        	['zona' => 'Villa La Florida', 'id_partido' => 19],
        	['zona' => 'San Francisco Solano', 'id_partido' => 19],

        	['zona' => 'San José', 'id_partido' => 20],
        	['zona' => 'José Marmol', 'id_partido' => 20],
        	['zona' => 'Rafael Calzada', 'id_partido' => 20],
        	['zona' => 'San Francisco Solano', 'id_partido' => 20],
        	['zona' => 'Claypole', 'id_partido' => 20],
        	['zona' => 'Adrogué', 'id_partido' => 20],
        	['zona' => 'Burzaco', 'id_partido' => 20],
        	['zona' => 'Malvinas Argentinas', 'id_partido' => 20],
        	['zona' => 'Don Orione', 'id_partido' => 20],
        	['zona' => 'LongChamps', 'id_partido' => 20],
        	['zona' => 'Glew', 'id_partido' => 20],
        	['zona' => 'Ministro Rivadavia', 'id_partido' => 20],

        	['zona' => 'Esteban Echeverría', 'id_partido' => 21],
        	['zona' => '9 de Abril', 'id_partido' => 21],
        	['zona' => 'Zona de Reserva', 'id_partido' => 21],
        	['zona' => 'Luis Cuillon', 'id_partido' => 21],
        	['zona' => 'Monte Grande', 'id_partido' => 21],
        	['zona' => 'El Jagüel', 'id_partido' => 21],
        	['zona' => 'Canning', 'id_partido' => 21],


        	['zona' => 'José María Ezeiza', 'id_partido' => 22],
        	['zona' => 'La Unión', 'id_partido' => 22],
        	['zona' => 'Tristán Suárez', 'id_partido' => 22],
        	['zona' => 'Canning', 'id_partido' => 22],
        	['zona' => 'Carlos Spegazzini', 'id_partido' => 22],

        	['zona' => 'Berazategui', 'id_partido' => 23],
        	['zona' => 'Berazategui Oeste', 'id_partido' => 23],
        	['zona' => 'Villa España', 'id_partido' => 23],
        	['zona' => 'Sourigues', 'id_partido' => 23],
        	['zona' => 'Ranelagh', 'id_partido' => 23],
        	['zona' => 'Plátanos', 'id_partido' => 23],
        	['zona' => 'Guillermo Hudson', 'id_partido' => 23],
        	['zona' => 'Juan María Gutiérrez', 'id_partido' => 23],
        	['zona' => 'El Pato', 'id_partido' => 23],
        	['zona' => 'Pereyra', 'id_partido' => 23],
        	['zona' => 'Zona de Reserva', 'id_partido' => 23],
        	
        	['zona' => 'Florencio Varela', 'id_partido' => 24],
        	['zona' => 'Gobernador Costa', 'id_partido' => 24],
        	['zona' => 'Zeballos', 'id_partido' => 24],
        	['zona' => 'Villa Vatteone', 'id_partido' => 24],
        	['zona' => 'Santa Rosa', 'id_partido' => 24],
        	['zona' => 'Bosques', 'id_partido' => 24],
        	['zona' => 'Villa San Luis', 'id_partido' => 24],
        	['zona' => 'Villa Brown', 'id_partido' => 24],
        	['zona' => 'Ingeniero Allan', 'id_partido' => 24],
        	['zona' => 'La Capilla', 'id_partido' => 24],

        	['zona' => '$', 'id_partido' => 25],
        	['zona' => 'Saavedra', 'id_partido' => 25],
        	['zona' => 'Coghlan', 'id_partido' => 25],
        	['zona' => 'Belgrano', 'id_partido' => 25],
        	['zona' => 'Villa Urquiza', 'id_partido' => 25],
        	['zona' => 'Palermo', 'id_partido' => 25],
        	['zona' => 'Colegiales', 'id_partido' => 25],
        	['zona' => 'Villa Ortúzar', 'id_partido' => 25],
        	['zona' => 'Parque Chas', 'id_partido' => 25],
        	['zona' => 'Chacarita', 'id_partido' => 25],
        	['zona' => 'Recoleta', 'id_partido' => 25],
        	['zona' => 'Retiro', 'id_partido' => 25],
        	['zona' => 'Villa Pueyrrendón', 'id_partido' => 25],
        	['zona' => 'Agronomía', 'id_partido' => 25],
        	['zona' => 'Villa Devoto', 'id_partido' => 25],
        	['zona' => 'Villa del Parque', 'id_partido' => 25],
        	['zona' => 'La Paternal', 'id_partido' => 25],
        	['zona' => 'Villa Crespo', 'id_partido' => 25],
        	['zona' => 'Villa Real', 'id_partido' => 25],
        	['zona' => 'Monte Castro', 'id_partido' => 25],
        	['zona' => 'Villa Santa Rita', 'id_partido' => 25],
        	['zona' => 'Villa General Mitre', 'id_partido' => 25],
        	['zona' => 'Caballito', 'id_partido' => 25],
        	['zona' => 'Almagro', 'id_partido' => 25],
        	['zona' => 'Balvanera', 'id_partido' => 25],
        	['zona' => 'San Nicolás', 'id_partido' => 25],
        	['zona' => 'Puerto Madero', 'id_partido' => 25],
        	['zona' => 'Monserrat', 'id_partido' => 25],
        	['zona' => 'San Telmo', 'id_partido' => 25],
        	['zona' => 'La Boca', 'id_partido' => 25],
        	['zona' => 'Constitución', 'id_partido' => 25],
        	['zona' => 'Barracas', 'id_partido' => 25],
        	['zona' => 'Parque Patricios', 'id_partido' => 25],
        	['zona' => 'San Cristóbal', 'id_partido' => 25],
        	['zona' => 'Boedo', 'id_partido' => 25],
        	['zona' => 'Parque Chacabuco', 'id_partido' => 25],
        	['zona' => 'Nueva Pompeya', 'id_partido' => 25],
        	['zona' => 'Flores', 'id_partido' => 25],
        	['zona' => 'Floresta', 'id_partido' => 25],
        	['zona' => 'Vélez Sársfield', 'id_partido' => 25],
        	['zona' => 'Villa Luro', 'id_partido' => 25],
        	['zona' => 'Versalles', 'id_partido' => 25],
        	['zona' => 'Liniers', 'id_partido' => 25],
        	['zona' => 'Mataderos', 'id_partido' => 25],
        	['zona' => 'Parque Avellaneda', 'id_partido' => 25],
        	['zona' => 'Villa Soldati', 'id_partido' => 25],
        	['zona' => 'Villa Lugano', 'id_partido' => 25],
        	['zona' => 'Villa Riachuelo', 'id_partido' => 25],

        	['zona' => 'Cañuelas', 'id_partido' => 26],
        	['zona' => 'Santa Rosa', 'id_partido' => 26],
        	['zona' => 'Alejandro Petión', 'id_partido' => 26],
        	['zona' => 'Máximo Paz', 'id_partido' => 26],
        	['zona' => 'Uribelarrea', 'id_partido' => 26],
        	['zona' => 'Vicente Casares', 'id_partido' => 26],
        	['zona' => 'Gobernador Udaondo', 'id_partido' => 26],
        	['zona' => 'El Taladro', 'id_partido' => 26],

        	['zona' => 'Ensenada', 'id_partido' => 27],
        	['zona' => 'Punta Lara', 'id_partido' => 27],
        	['zona' => 'Villa Catella', 'id_partido' => 27],
        	['zona' => 'Dique N° 1', 'id_partido' => 27],
        	['zona' => 'Isla Santiago Oeste', 'id_partido' => 27],

        	['zona' => 'Berisso', 'id_partido' => 28],
        	['zona' => 'Villa Progreso', 'id_partido' => 28],
        	['zona' => 'Villa San Carlos', 'id_partido' => 28],
        	['zona' => 'Villa Independencia', 'id_partido' => 28],
        	['zona' => 'Barrio El Carmen Este', 'id_partido' => 28],
        	['zona' => 'Villa Dolores', 'id_partido' => 28],
        	['zona' => 'Villa Argüello', 'id_partido' => 28],
        	['zona' => 'Villa Zula', 'id_partido' => 28],
        	['zona' => 'Barrio Banco Provincia', 'id_partido' => 28],
        	['zona' => 'Villa Nueva', 'id_partido' => 28],
        	['zona' => 'Barrio Universitario', 'id_partido' => 28],
        	['zona' => 'Los Talas', 'id_partido' => 28],
        	['zona' => 'Palo Blanco', 'id_partido' => 28],
        	['zona' => 'Villa Banco Constructor', 'id_partido' => 28],
        	['zona' => 'Los Catorce', 'id_partido' => 28],
        	['zona' => 'Villa España', 'id_partido' => 28],
        	['zona' => 'La Balandra', 'id_partido' => 28],
        	['zona' => 'Juan B. Justo', 'id_partido' => 28],
        	['zona' => 'Barrio Obrero', 'id_partido' => 28],
        	['zona' => 'Barrio Santa Teresita', 'id_partido' => 28],

        	['zona' => 'Campana', 'id_partido' => 29],
        	['zona' => 'Alto Los Cardales', 'id_partido' => 29],
        	['zona' => 'Pavón', 'id_partido' => 29],
        	['zona' => 'Arroyo de La Cruz', 'id_partido' => 29],

        	['zona' => 'Brandsen', 'id_partido' => 30],
        	['zona' => 'Jeppener', 'id_partido' => 30],
        	['zona' => 'Gómez', 'id_partido' => 30],
        	['zona' => 'Altamirano', 'id_partido' => 30],
        	['zona' => 'Samborombón', 'id_partido' => 30],
        	['zona' => 'Oliden', 'id_partido' => 30],
        	['zona' => 'La Posada', 'id_partido' => 30],

        	['zona' => 'Capilla del Señor', 'id_partido' => 31],
        	['zona' => 'Los Cardales', 'id_partido' => 31],
        	['zona' => 'Pavón', 'id_partido' => 31],
        	['zona' => 'Arroyo de La Cruz', 'id_partido' => 31],
        	['zona' => 'Parada Orlando', 'id_partido' => 31],
        	['zona' => 'Parada Robles', 'id_partido' => 31],
        	['zona' => 'El Remanso', 'id_partido' => 31],
        	['zona' => 'Etchegoyen', 'id_partido' => 31],
        	['zona' => 'Parada La Lata', 'id_partido' => 31],
        	['zona' => 'Diego Gaynor', 'id_partido' => 31],
        	['zona' => 'Gobernador Andonaegui', 'id_partido' => 31],
        	['zona' => 'Chenaut', 'id_partido' => 31],
        	['zona' => 'La Loma', 'id_partido' => 31],

        	['zona' => 'General Las Heras', 'id_partido' => 32],
        	['zona' => 'VillarS', 'id_partido' => 32],
        	['zona' => 'General Hornos', 'id_partido' => 32],
        	['zona' => 'Plomer', 'id_partido' => 32],
        	['zona' => 'La Choza', 'id_partido' => 32],
        	['zona' => 'Lozano', 'id_partido' => 32],
        	['zona' => 'Enrique Fynn', 'id_partido' => 32],

        	['zona' => 'Luján', 'id_partido' => 33],
        	['zona' => 'Carlos Keen', 'id_partido' => 33],
        	['zona' => 'Cortinez', 'id_partido' => 33],
        	['zona' => 'Jáuregui', 'id_partido' => 33],
        	['zona' => 'Olivera', 'id_partido' => 33],
        	['zona' => 'Open Door', 'id_partido' => 33],
        	['zona' => 'Torres', 'id_partido' => 33],
        	['zona' => 'Lezica y Torrezuri', 'id_partido' => 33],

        	['zona' => 'Marcos Paz', 'id_partido' => 34],
        	['zona' => 'Elías Romero', 'id_partido' => 34],
        	['zona' => 'Santa Rosa', 'id_partido' => 34],
        	['zona' => 'Lisandro de la Torre', 'id_partido' => 34],
        	['zona' => 'Santa Marta', 'id_partido' => 34],

        	['zona' => 'Panamérica', 'id_partido' => 35],
        	['zona' => 'Parque Las Naciones', 'id_partido' => 35],
        	['zona' => 'Parque Americano', 'id_partido' => 35],
        	['zona' => 'La Yaya', 'id_partido' => 35],
        	['zona' => 'Las Lomas', 'id_partido' => 35],
        	['zona' => 'San Martín', 'id_partido' => 35],
        	['zona' => 'Santa Elena', 'id_partido' => 35],
        	['zona' => 'Santa Magdalena', 'id_partido' => 35],
        	['zona' => 'Santa Teresita', 'id_partido' => 35],
        	['zona' => 'Centro', 'id_partido' => 35],
        	['zona' => '25 de Mayo', 'id_partido' => 35],
        	['zona' => 'Santa Rosa de Lima', 'id_partido' => 35],
        	['zona' => 'Copenhague', 'id_partido' => 35],
        	['zona' => 'San Roque', 'id_partido' => 35],
        	['zona' => 'Los Pinos', 'id_partido' => 35],
        	['zona' => 'Los Robles', 'id_partido' => 35],
        	['zona' => 'América Unida', 'id_partido' => 35],
        	['zona' => 'El Ministro', 'id_partido' => 35],
        	['zona' => 'Agrocolonia', 'id_partido' => 35],
        	['zona' => 'San Pablo', 'id_partido' => 35],
        	['zona' => 'Villa Numancia', 'id_partido' => 35],
        	['zona' => 'El Triángulo', 'id_partido' => 35],
        	['zona' => 'Guernica', 'id_partido' => 35],

        	['zona' => 'San Vicente', 'id_partido' => 36],
        	['zona' => 'Alejandro Korn', 'id_partido' => 36],
        	['zona' => 'Domselaar', 'id_partido' => 36],

        	['zona' => 'Zárate', 'id_partido' => 37],
        	['zona' => 'Lima', 'id_partido' => 37],
        	['zona' => 'Escalada', 'id_partido' => 37],
        	['zona' => 'Paraje Ortíz', 'id_partido' => 37],

        	['zona' => 'La Plata', 'id_partido' => 38],
        	['zona' => 'San Carlos', 'id_partido' => 38],
        	['zona' => 'Tolosa', 'id_partido' => 38],
        	['zona' => 'Gonnet', 'id_partido' => 38],
        	['zona' => 'City Bell', 'id_partido' => 38],
        	['zona' => 'Transradio', 'id_partido' => 38],
        	['zona' => 'Villa Elisa', 'id_partido' => 38],
        	['zona' => 'Arturo Seguí', 'id_partido' => 38],
        	['zona' => 'Melchor Romero', 'id_partido' => 38],
        	['zona' => 'Casco Urbano', 'id_partido' => 38],
        	['zona' => 'Los Hornos', 'id_partido' => 38],
        	['zona' => 'Abasto', 'id_partido' => 38],
        	['zona' => 'Lisandro Olmos', 'id_partido' => 38],
        	['zona' => 'Altos de San Lorenzo', 'id_partido' => 38],
        	['zona' => 'Villa Elvira', 'id_partido' => 38],
        	['zona' => 'Villa Progreso', 'id_partido' => 38],
        	['zona' => 'Romero', 'id_partido' => 38],
        	['zona' => 'Riguelet', 'id_partido' => 38],
        	['zona' => 'Sicardi', 'id_partido' => 38],
        	['zona' => 'Etcheverry', 'id_partido' => 38]
        ]);
    }
}
