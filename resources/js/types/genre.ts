

export enum GenreType {
  HOMME = 'Homme',
  FEMME = 'Femme',
}

export interface Genre {
  id: GenreType;
  nom: string;
}

export const genres: Genre[] = [
  { id: GenreType.HOMME, nom: GenreType.HOMME },
  { id: GenreType.FEMME, nom: GenreType.FEMME },
];


export const isHomme = (id: string) => id === GenreType.HOMME;
export const isFemme = (id: string) => id === GenreType.FEMME;
