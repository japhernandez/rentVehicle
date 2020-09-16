export interface RentInterface {
  id: string;
  vehicle_id: number;
  user_id: number;
  delivery_date: string;
  departure_date: string;
  payment_method: string;
  total_price: number;
}
