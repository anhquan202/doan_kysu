class RemoveCustomerForeignKeyFromContract < ActiveRecord::Migration[8.0]
  def change
     remove_reference :contracts, :customer, foreign_key: { to_table: :customers }
  end
end
