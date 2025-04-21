<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    //
    {
        Book::create([
            "id" => 4,
            "isbn" => "9788497945301",
            "name" => "las mil y una noches",
            "url" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSp8Zkv0TNx1BBolgQaw5cGYMWs6qmSsVAb6C2ST86YBGc3hFOInUouTocuuMBUX-vJ2MI&usqp=CAU",
            "state" => 1,
            "quantity" => 10,
            "price" => 71200,
            "sypnosis" => "Las mil y una noches forman un libro exótico, que refleja costumbres extrañas, mucho más libres que las nuestras; sistemas de vida que contrastan con nuestro concepto cristiano; diferentes modos de ver y sentir el acontecer diario, siempre presidido por un fatalismo invencible: «Está escrito en el libro del Destino». Constituyen un retrato acabado y perfecto de la vida, costumbres y cualidades de aquel complejo mundo, desde los tiempos patriarcales de Mahoma a la decadencia y desmembración del Imperio, pasando por el refinamiento y grandeza de Bagdad."
        ]);
        Book::create([
            "id" => 5,
            "ISBN" => "9789585219649",
            "name" => "1984",
            "url" => "https://cravenwild.com/wp-content/uploads/2016/11/1984-by-george-orwell-1-638.jpg?w=478&h=677",
            "state" => 1,
            "quantity" => 8,
            "price" => 36000,
            "sypnosis" => "En el año 1984 Londres es una ciudad lúgubre en la que la Policía del Pensamiento controla de forma asfixiante la vida de los ciudadanos. Winston Smith es un peón de este engranaje perverso y su cometido es reescribir la historia para adaptarla a lo que el Partido considera la versión oficial de los hechos. Hasta que decide replantearse la verdad del sistema que los gobierna y somete."
        ]);
        Book::create([
            "id" => 6,
            "ISBN" => "9789807716161",
            "name" => "El principito",
            "url" => "https://cdn.grupoelcorteingles.es/SGFM/dctm/MEDIA03/202303/21/00106524009492____1__1200x1200.jpg",
            "state" => 1,
            "quantity" => 15,
            "price" => 31900,
            "sypnosis" => "El Principito es una fábula infantil disfrutada por niños y adultos por igual. Publicada por primera vez en 1943, la novela ha sido traducida a más de 250 idiomas, incluida una versión en braille. También es uno de los libros más vendidos en el mundo después de La Biblia y El capital,  de Karl Marx.El autor se estrella con su avión en medio del desierto del Sahara y encuentra a un niño, que es un príncipe en otro planeta. Se trata de un relato poético que es filosófico e incluye crítica social. Hace diversas observaciones sobre la naturaleza humana y su lectura es placentera y al mismo tiempo invita a la reflexión.Y naturalmente, está pensado para lectores de todas las edades.."
        ]);
    }
}
